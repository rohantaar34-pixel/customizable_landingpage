<?php
include "includes/config.php";
$conn = conn();
?>
<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>

<!-- Add Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<!-- Add SweetAlert2 CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<section class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 md:px-[7%]">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-6 flex justify-between items-center">
            <a href="dashboard.php"
                class="inline-flex items-center gap-2 bg-[#f4c49a] hover:bg-[#e5b589] text-[#3c5170] font-semibold text-lg rounded-lg px-4 py-2 transition-all duration-200 shadow-sm hover:shadow-md">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Dashboard
            </a>
            <h1 class="text-3xl font-bold text-[#3c5170]">Analytics & Booking Management</h1>
        </div>

        <!-- Loading Indicator -->
        <div id="loading" class="text-center py-8">
            <i class="fa-solid fa-spinner fa-spin text-4xl text-[#3c5170]"></i>
            <p class="mt-2 text-gray-600">Loading analytics data...</p>
        </div>

        <!-- Main Content (Hidden until data loads) -->
        <div id="mainContent" style="display: none;">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Bookings Card -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-[#3c5170]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Bookings</p>
                            <p class="text-3xl font-bold text-[#3c5170]" id="totalBookings">0</p>
                        </div>
                        <div class="bg-[#3c5170] bg-opacity-10 rounded-full p-3">
                            <i class="fa-solid fa-calendar-check text-2xl text-[#3c5170]"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending Bookings Card -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Pending</p>
                            <p class="text-3xl font-bold text-yellow-600" id="pendingBookings">0</p>
                        </div>
                        <div class="bg-yellow-100 rounded-full p-3">
                            <i class="fa-solid fa-clock text-2xl text-yellow-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Approved Bookings Card -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Approved</p>
                            <p class="text-3xl font-bold text-green-600" id="approvedBookings">0</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <i class="fa-solid fa-check-circle text-2xl text-green-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue Card -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-[#f4c49a]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Revenue</p>
                            <p class="text-3xl font-bold text-[#3c5170]" id="totalRevenue">$0</p>
                        </div>
                        <div class="bg-[#f4c49a] bg-opacity-30 rounded-full p-3">
                            <i class="fa-solid fa-dollar-sign text-2xl text-[#3c5170]"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Revenue Trend Chart -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-semibold text-[#3c5170] mb-4">Monthly Revenue Trend</h3>
                    <div style="height: 300px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Status Distribution Chart -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-semibold text-[#3c5170] mb-4">Booking Status Distribution</h3>
                    <div style="height: 300px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Bookings Management Table -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-semibold text-[#3c5170] mb-4">Booking Management</h3>
                
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ref</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date/Time</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="bookingsTableBody" class="bg-white divide-y divide-gray-200">
                            <!-- Bookings will be loaded here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Email Modal -->
<div id="emailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display: none;">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-[#3c5170]" id="modalTitle">Approve Booking</h3>
                <button onclick="closeEmailModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-times text-2xl"></i>
                </button>
            </div>

            <!-- Booking Details Preview -->
            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <h4 class="font-semibold text-gray-700 mb-2">Booking Details:</h4>
                <p id="modalBookingDetails" class="text-sm text-gray-600"></p>
            </div>

            <!-- Email Message Input -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Custom Message:</label>
                <textarea id="emailMessageInput" rows="6" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3c5170]"
                    placeholder="Enter your custom message here..."></textarea>
                <p class="text-sm text-gray-500 mt-1">This message will be included in the email notification to the customer.</p>
            </div>

            <!-- Preset Message Templates -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Or use a preset template:</label>
                <div class="space-y-2">
                    <button onclick="usePresetMessage('approve')" 
                        class="w-full text-left px-4 py-2 bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg text-sm">
                        <strong>Approval Template:</strong> We're pleased to confirm your booking...
                    </button>
                    <button onclick="usePresetMessage('decline')" 
                        class="w-full text-left px-4 py-2 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg text-sm">
                        <strong>Decline Template:</strong> We regret to inform you that we cannot accommodate...
                    </button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <button onclick="closeEmailModal()" 
                    class="flex-1 px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold rounded-lg transition">
                    Cancel
                </button>
                <button onclick="confirmBookingAction()" id="confirmButton"
                    class="flex-1 px-6 py-3 bg-[#3c5170] hover:bg-[#2d3e54] text-white font-semibold rounded-lg transition">
                    Send & Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Smooth scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #3c5170;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #2d3e54;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-approved {
        background: #d1fae5;
        color: #065f46;
    }

    .status-declined {
        background: #fee2e2;
        color: #991b1b;
    }
</style>

<script>
// Global variables
let currentBookingId = null;
let currentBookingAction = null;
let allBookingsData = [];
let revenueChart = null;
let statusChart = null;

// Preset email templates
const emailTemplates = {
    approve: `Dear valued customer,

We're pleased to confirm your booking with In & Out Cleaning Experts!

Your booking has been approved and our team is excited to provide you with exceptional cleaning service. We will contact you within 24 hours to confirm all the details and ensure everything is prepared for your scheduled service.

Thank you for choosing In & Out Cleaning Experts. We look forward to serving you!

Best regards,
In & Out Cleaning Experts Team`,
    
    decline: `Dear valued customer,

Thank you for your interest in In & Out Cleaning Experts.

We regret to inform you that we are unable to accommodate your booking at this time due to scheduling constraints. We apologize for any inconvenience this may cause.

We would be happy to help you find an alternative date or time that works better. Please feel free to contact us directly to discuss other options.

Thank you for your understanding.

Best regards,
In & Out Cleaning Experts Team`
};

// Load data on page load
document.addEventListener('DOMContentLoaded', function() {
    loadAnalyticsData();
});

// Function to load analytics data
function loadAnalyticsData() {
    fetch('booking_management_api.php?action=get_bookings')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                allBookingsData = data.bookings;
                updateStatistics(data.analytics);
                createCharts(data.charts);
                renderBookingsTable(data.bookings);
                
                // Hide loading, show content
                document.getElementById('loading').style.display = 'none';
                document.getElementById('mainContent').style.display = 'block';
            } else {
                showError('Failed to load analytics data');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Error loading data: ' + error.message);
        });
}

// Update statistics cards
function updateStatistics(analytics) {
    document.getElementById('totalBookings').textContent = analytics.total_bookings || 0;
    document.getElementById('pendingBookings').textContent = analytics.pending_count || 0;
    document.getElementById('approvedBookings').textContent = analytics.approved_count || 0;
    document.getElementById('totalRevenue').textContent = '$' + (analytics.total_revenue || 0).toFixed(2);
}

// Create charts
function createCharts(charts) {
    // Revenue Trend Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    if (revenueChart) revenueChart.destroy();
    
    const months = charts.monthly_revenue.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
    });
    const revenues = charts.monthly_revenue.map(item => item.revenue);
    
    revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Revenue ($)',
                data: revenues,
                borderColor: '#3c5170',
                backgroundColor: 'rgba(60, 81, 112, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });

    // Status Distribution Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    if (statusChart) statusChart.destroy();
    
    statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Approved', 'Declined'],
            datasets: [{
                data: [
                    charts.status_distribution.pending,
                    charts.status_distribution.approved,
                    charts.status_distribution.declined
                ],
                backgroundColor: ['#fbbf24', '#10b981', '#ef4444'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        }
    });
}

// Render bookings table
function renderBookingsTable(bookings) {
    const tbody = document.getElementById('bookingsTableBody');
    tbody.innerHTML = '';
    
    if (bookings.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">No bookings found</td></tr>';
        return;
    }
    
    bookings.forEach(booking => {
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50';
        
        const statusClass = `status-${booking.status}`;
        const actionsHtml = booking.status === 'pending' 
            ? `
                <button onclick="openEmailModal(${booking.id}, 'approve')" 
                    class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-sm rounded mr-2">
                    <i class="fa-solid fa-check"></i> Approve
                </button>
                <button onclick="openEmailModal(${booking.id}, 'decline')" 
                    class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-sm rounded">
                    <i class="fa-solid fa-times"></i> Decline
                </button>
            `
            : '<span class="text-gray-400 text-sm">No actions</span>';
        
        row.innerHTML = `
            <td class="px-4 py-3 text-sm">${booking.booking_ref}</td>
            <td class="px-4 py-3 text-sm">
                <div class="font-medium">${booking.customer_name}</div>
                <div class="text-gray-500 text-xs">${booking.customer_email}</div>
            </td>
            <td class="px-4 py-3 text-sm">${booking.service || 'N/A'}</td>
            <td class="px-4 py-3 text-sm">
                <div>${booking.booking_date || 'N/A'}</div>
                <div class="text-gray-500 text-xs">${booking.booking_time}</div>
            </td>
            <td class="px-4 py-3 text-sm font-medium">$${parseFloat(booking.price || 0).toFixed(2)}</td>
            <td class="px-4 py-3 text-sm">
                <span class="status-badge ${statusClass}">${booking.status}</span>
            </td>
            <td class="px-4 py-3 text-sm">${actionsHtml}</td>
        `;
        
        tbody.appendChild(row);
    });
}

// Open email modal
function openEmailModal(bookingId, action) {
    currentBookingId = bookingId;
    currentBookingAction = action;
    
    const booking = allBookingsData.find(b => b.id == bookingId);
    if (!booking) {
        showError('Booking not found');
        return;
    }
    
    // Update modal title
    document.getElementById('modalTitle').textContent = 
        action === 'approve' ? 'Approve Booking' : 'Decline Booking';
    
    // Update booking details
    document.getElementById('modalBookingDetails').innerHTML = `
        <strong>Ref:</strong> ${booking.booking_ref}<br>
        <strong>Customer:</strong> ${booking.customer_name}<br>
        <strong>Service:</strong> ${booking.service}<br>
        <strong>Date:</strong> ${booking.booking_date} at ${booking.booking_time}<br>
        <strong>Price:</strong> $${parseFloat(booking.price || 0).toFixed(2)}
    `;
    
    // Set default message
    document.getElementById('emailMessageInput').value = emailTemplates[action];
    
    // Show modal
    document.getElementById('emailModal').style.display = 'flex';
}

// Close email modal
function closeEmailModal() {
    document.getElementById('emailModal').style.display = 'none';
    currentBookingId = null;
    currentBookingAction = null;
    document.getElementById('emailMessageInput').value = '';
}

// Use preset message
function usePresetMessage(type) {
    document.getElementById('emailMessageInput').value = emailTemplates[type];
}

// Confirm booking action
function confirmBookingAction() {
    const emailMessage = document.getElementById('emailMessageInput').value.trim();
    
    if (!emailMessage) {
        Swal.fire({
            icon: 'warning',
            title: 'Message Required',
            text: 'Please enter a message for the customer.'
        });
        return;
    }
    
    // Disable button
    const confirmBtn = document.getElementById('confirmButton');
    confirmBtn.disabled = true;
    confirmBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';
    
    // Send request
    const formData = new FormData();
    formData.append('action', 'update_booking');
    formData.append('booking_id', currentBookingId);
    formData.append('booking_action', currentBookingAction);
    formData.append('email_message', emailMessage);
    
    fetch('booking_management_api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        confirmBtn.disabled = false;
        confirmBtn.innerHTML = 'Send & Confirm';
        
        if (data.success) {
            closeEmailModal();
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                timer: 1500
            });
            
            // Reload data
            setTimeout(() => {
                loadAnalyticsData();
            }, 1500);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            });
        }
    })
    .catch(error => {
        confirmBtn.disabled = false;
        confirmBtn.innerHTML = 'Send & Confirm';
        console.error('Error:', error);
        showError('Error processing request: ' + error.message);
    });
}

// Show error message
function showError(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message
    });
}
</script>

<?php include "includes/footer.php" ?>