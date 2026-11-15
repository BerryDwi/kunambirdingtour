import Chart from 'chart.js/auto';

const colors = {
    green: '#087d50',
    navy: '#172b40',
    amber: '#d97706',
    red: '#dc2626',
};

function chartData(elementId) {
    const element = document.getElementById(elementId);

    if (! element) {
        return null;
    }

    try {
        return JSON.parse(element.dataset.chart ?? '{}');
    } catch {
        return null;
    }
}

function baseScales() {
    return {
        y: {
            beginAtZero: true,
            ticks: { precision: 0 },
            grid: { color: 'rgba(148, 163, 184, 0.15)' },
        },
        x: {
            grid: { display: false },
        },
    };
}

export function initDashboardCharts() {
    const toursByYear = chartData('tours-by-year-chart');
    const inboxTrend = chartData('inbox-trend-chart');
    const tourStatus = chartData('tour-status-chart');

    if (toursByYear) {
        new Chart(document.getElementById('tours-by-year-chart'), {
            type: 'bar',
            data: {
                labels: toursByYear.labels,
                datasets: [
                    {
                        label: 'Tours',
                        data: toursByYear.values,
                        backgroundColor: colors.green,
                        borderRadius: 6,
                        maxBarThickness: 44,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: baseScales(),
            },
        });
    }

    if (inboxTrend) {
        new Chart(document.getElementById('inbox-trend-chart'), {
            type: 'line',
            data: {
                labels: inboxTrend.labels,
                datasets: [
                    {
                        label: 'Bookings',
                        data: inboxTrend.bookings,
                        borderColor: colors.green,
                        backgroundColor: 'rgba(8, 125, 80, 0.12)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 3,
                    },
                    {
                        label: 'Messages',
                        data: inboxTrend.messages,
                        borderColor: colors.amber,
                        backgroundColor: 'rgba(217, 119, 6, 0.10)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 3,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, boxWidth: 8 },
                    },
                },
                scales: baseScales(),
            },
        });
    }

    if (tourStatus) {
        new Chart(document.getElementById('tour-status-chart'), {
            type: 'doughnut',
            data: {
                labels: tourStatus.labels,
                datasets: [
                    {
                        data: tourStatus.values,
                        backgroundColor: [colors.green, colors.red, colors.amber],
                        borderWidth: 0,
                        hoverOffset: 4,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, boxWidth: 8 },
                    },
                },
            },
        });
    }
}
