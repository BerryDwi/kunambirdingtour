<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactMessageController extends Controller
{
    /**
     * Display a filtered listing of contact messages.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'string', 'max:50'],
        ]);

        $messages = $this->filteredQuery($request)
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.contact-messages.index', [
            'messages' => $messages,
            'filters' => $filters,
            'statuses' => MessageStatus::cases(),
        ]);
    }

    /**
     * Display the given message and mark it as read.
     */
    public function show(ContactMessage $contactMessage): View
    {
        if ($contactMessage->status === MessageStatus::New) {
            $contactMessage->update(['status' => MessageStatus::Read]);
            $contactMessage->refresh();
        }

        return view('admin.contact-messages.show', [
            'contactMessage' => $contactMessage,
            'statuses' => MessageStatus::cases(),
        ]);
    }

    /**
     * Update the status of the given message.
     */
    public function update(ContactMessageRequest $request, ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->update($request->validated());

        return redirect()
            ->route('admin.contact-messages.show', $contactMessage)
            ->with('status', 'Contact message updated successfully.');
    }

    /**
     * Delete the given message.
     */
    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()
            ->route('admin.contact-messages.index')
            ->with('status', 'Contact message deleted successfully.');
    }

    /**
     * Export the filtered messages as CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $messages = $this->filteredQuery($request)->latest()->get();

        return response()->streamDownload(function () use ($messages): void {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Name', 'Email', 'Phone', 'Status', 'Message', 'Received at']);

            foreach ($messages as $message) {
                fputcsv($handle, [
                    $message->first_name.' '.$message->last_name,
                    $message->email,
                    $message->phone,
                    $message->status?->label(),
                    $message->message,
                    $message->created_at?->format('Y-m-d H:i'),
                ]);
            }

            fclose($handle);
        }, 'contact-messages-'.now()->format('Y-m-d').'.csv');
    }

    /**
     * Build the filtered message query shared by the listing and export.
     */
    private function filteredQuery(Request $request): Builder
    {
        return ContactMessage::query()
            ->when($request->string('search')->trim()->toString(), function (Builder $query, string $search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn (Builder $query) => $query->where('status', $request->input('status')));
    }
}
