<?php
include "includes/config.php";
$conn = conn();
?>
<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>

<?php include "includes/select-about-cms.php" ?>
<?php include "backend/cms-aboutpage.php" ?>

<!-- Add SweetAlert2 CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<section class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 md:px-[7%] ">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-6">
            <a href="dashboard.php"
                class="inline-flex items-center gap-2 bg-[#f4c49a] hover:bg-[#e5b589] text-[#3c5170] font-semibold text-lg rounded-lg px-4 py-2 transition-all duration-200 shadow-sm hover:shadow-md">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Dashboard
            </a>
        </div>

        <!-- Page Title -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-[#3c5170] mb-2">Services Management</h1>
                    <p class="text-gray-600">Manage your services and add-ons efficiently</p>
                </div>
                <button type="button" onclick="openAddServiceModal()"
                    class="inline-flex items-center justify-center gap-2 bg-[#3c5170] hover:bg-[#2d3e54] text-white font-semibold px-6 py-3 rounded-lg transition-all duration-200 shadow-md hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-plus"></i>
                    <span>Add New Service</span>
                </button>
            </div>
        </div>

        <!-- Services List -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-1 h-8 bg-[#3c5170] rounded"></div>
                <h2 class="text-2xl font-bold text-gray-800">Available Services</h2>
            </div>

            <div id="servicesList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Services will be loaded here via AJAX -->
                <div class="col-span-full flex items-center justify-center py-12">
                    <div class="text-center">
                        <i class="fa-solid fa-spinner fa-spin text-4xl text-[#3c5170] mb-3"></i>
                        <p class="text-gray-500">Loading services...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Load services on page load
    document.addEventListener('DOMContentLoaded', function () {
        loadServices();
    });

    // Function to update GST calculation
    function updateGSTCalculation() {
        const priceInput = document.getElementById('service_price');
        const gstCheckbox = document.getElementById('gst_checkbox');
        const gstDisplay = document.getElementById('gst_display');
        const gstAmount = document.getElementById('gst_amount');
        const totalWithGst = document.getElementById('total_with_gst');

        if (!priceInput || !gstCheckbox || !gstDisplay) return;

        const price = parseFloat(priceInput.value) || 0;
        const isGstChecked = gstCheckbox.checked;

        if (isGstChecked && price > 0) {
            const gst = price * 0.12;
            const total = price + gst;

            gstAmount.textContent = gst.toFixed(2);
            totalWithGst.textContent = total.toFixed(2);
            gstDisplay.classList.remove('hidden');
        } else {
            gstDisplay.classList.add('hidden');
        }
    }

    // Function to open Add Service modal
    function openAddServiceModal() {
        Swal.fire({
            title: '<div class="flex items-center gap-3"><i class="fa-solid fa-plus-circle text-[#3c5170]"></i><span>Add New Service</span></div>',
            html: `
        <div class="text-left space-y-4 px-2">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fa-solid fa-tag text-[#3c5170]"></i> Service Name *
                </label>
                <input id="service_name" 
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#3c5170] focus:ring-2 focus:ring-[#3c5170]/20 transition-all outline-none" 
                       placeholder="e.g., Premium Car Wash">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fa-solid fa-dollar-sign text-[#3c5170]"></i> Base Price *
                </label>
                <input id="service_price" 
                       type="number" 
                       step="0.01" 
                       min="0"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#3c5170] focus:ring-2 focus:ring-[#3c5170]/20 transition-all outline-none" 
                       placeholder="e.g., 48.00"
                       oninput="updateGSTCalculation()">
            </div>

            <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4">
                <div class="flex items-center gap-3 mb-3">
                    <input type="checkbox" 
                           id="gst_checkbox" 
                           class="w-5 h-5 text-[#3c5170] border-2 border-gray-300 rounded focus:ring-2 focus:ring-[#3c5170]/20 cursor-pointer"
                           onchange="updateGSTCalculation()">
                    <label for="gst_checkbox" class="text-sm font-bold text-gray-700 cursor-pointer">
                        <i class="fa-solid fa-percent text-[#3c5170]"></i> Add 10% GST
                    </label>
                </div>
                <div id="gst_display" class="text-sm text-gray-600 ml-8 hidden">
                    <div class="flex justify-between items-center">
                        <span>GST Amount (10%):</span>
                        <span class="font-bold text-green-600">$<span id="gst_amount">0.00</span></span>
                    </div>
                    <div class="flex justify-between items-center mt-1 pt-2 border-t border-blue-300">
                        <span class="font-semibold">Total with GST:</span>
                        <span class="font-bold text-[#3c5170] text-lg">$<span id="total_with_gst">0.00</span></span>
                    </div>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fa-solid fa-file-text text-[#3c5170]"></i> Service Description *
                </label>
                <textarea id="service_desc" 
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#3c5170] focus:ring-2 focus:ring-[#3c5170]/20 transition-all outline-none resize-none" 
                          rows="4" 
                          placeholder="Describe your service in detail..."></textarea>
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fa-solid fa-puzzle-piece text-[#3c5170]"></i> Add-ons (Optional)
                </label>
                <div id="addons_container" class="space-y-2">
                    <div class="relative flex items-center gap-2">
                        <input type="text" 
                               class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#3c5170] focus:ring-2 focus:ring-[#3c5170]/20 transition-all outline-none addon-name" 
                               placeholder="e.g., Wax Polish">
                        <input type="number" 
                               step="0.01" 
                               min="0"
                               class="w-28 px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#3c5170] focus:ring-2 focus:ring-[#3c5170]/20 transition-all outline-none addon-price" 
                               placeholder="Price">
                    </div>
                </div>
                <button type="button" 
                        onclick="addAddonField()" 
                        class="mt-3 w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-sm hover:shadow-md">
                    <i class="fa-solid fa-plus"></i>
                    <span>Add Another Add-on</span>
                </button>
            </div>
        </div>
    `,
            showCancelButton: true,
            confirmButtonText: '<i class="fa-solid fa-save mr-2"></i>Save Service',
            confirmButtonColor: '#3c5170',
            cancelButtonText: '<i class="fa-solid fa-times mr-2"></i>Cancel',
            cancelButtonColor: '#6b7280',
            width: '650px',
            padding: '2rem',
            customClass: {
                popup: 'rounded-2xl shadow-2xl',
                title: 'text-2xl font-bold text-gray-800',
                htmlContainer: 'mt-4',
                confirmButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all',
                cancelButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all'
            },
            preConfirm: () => {
                const serviceName = document.getElementById('service_name').value.trim();
                const servicePrice = document.getElementById('service_price').value.trim();
                const serviceDesc = document.getElementById('service_desc').value.trim();
                const gstChecked = document.getElementById('gst_checkbox').checked;

                if (!serviceName || !servicePrice || !serviceDesc) {
                    Swal.showValidationMessage('<i class="fa-solid fa-exclamation-circle mr-2"></i>Please fill in all required fields');
                    return false;
                }

                if (parseFloat(servicePrice) < 0) {
                    Swal.showValidationMessage('<i class="fa-solid fa-exclamation-circle mr-2"></i>Price must be greater than or equal to 0');
                    return false;
                }

                const addonNames = document.querySelectorAll('.addon-name');
                const addonPrices = document.querySelectorAll('.addon-price');
                const addons = [];

                addonNames.forEach((nameInput, index) => {
                    const name = nameInput.value.trim();
                    const price = addonPrices[index].value.trim();

                    if (name && price) {
                        addons.push({
                            name: name,
                            price: parseFloat(price)
                        });
                    }
                });

                // Calculate GST if checkbox is checked
                const gstFee = gstChecked ? parseFloat(servicePrice) * 0.10 : null;

                return {
                    service_name: serviceName,
                    price: parseFloat(servicePrice),
                    service_desc: serviceDesc,
                    GST_FEE: gstFee,
                    has_gst: gstChecked,
                    addons: addons
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                saveService(result.value);
            }
        });
    }

    // Function to add addon input field with remove button
    function addAddonField() {
        const container = document.getElementById('addons_container');

        const wrapper = document.createElement('div');
        wrapper.className = 'relative flex items-center gap-2';
        wrapper.innerHTML = `
            <input type="text" 
                   class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#3c5170] focus:ring-2 focus:ring-[#3c5170]/20 transition-all outline-none addon-name" 
                   placeholder="e.g., Interior Cleaning">
            <input type="number" 
                   step="0.01" 
                   min="0"
                   class="w-28 px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#3c5170] focus:ring-2 focus:ring-[#3c5170]/20 transition-all outline-none addon-price" 
                   placeholder="Price">
            <button type="button" 
                    onclick="this.parentElement.remove()" 
                    class="px-3 py-3 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all">
                <i class="fa-solid fa-trash"></i>
            </button>
        `;
        container.appendChild(wrapper);
    }

    // Function to save service
    function saveService(data) {
        Swal.fire({
            title: 'Saving...',
            html: '<i class="fa-solid fa-spinner fa-spin text-3xl text-[#3c5170]"></i>',
            showConfirmButton: false,
            allowOutsideClick: false
        });

        fetch('backend/save-service.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '<span class="text-green-600">Success!</span>',
                        html: '<p class="text-gray-600">Service has been added successfully</p>',
                        confirmButtonColor: '#3c5170',
                        confirmButtonText: 'Great!',
                        customClass: {
                            popup: 'rounded-2xl'
                        }
                    }).then(() => {
                        loadServices();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '<span class="text-red-600">Error!</span>',
                        html: `<p class="text-gray-600">${result.message || 'Failed to add service'}</p>`,
                        confirmButtonColor: '#3c5170',
                        customClass: {
                            popup: 'rounded-2xl'
                        }
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: '<span class="text-red-600">Error!</span>',
                    html: '<p class="text-gray-600">An error occurred while saving the service</p>',
                    confirmButtonColor: '#3c5170',
                    customClass: {
                        popup: 'rounded-2xl'
                    }
                });
            });
    }

    // Function to load services
    function loadServices() {
        fetch('backend/get-services.php')
            .then(response => response.json())
            .then(services => {
                const servicesList = document.getElementById('servicesList');
                if (services.length === 0) {
                    servicesList.innerHTML = `
                        <div class="col-span-full flex flex-col items-center justify-center py-16">
                            <div class="text-center">
                                <i class="fa-solid fa-box-open text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Services Yet</h3>
                                <p class="text-gray-400">Click "Add New Service" to get started</p>
                            </div>
                        </div>
                    `;
                } else {
                    servicesList.innerHTML = services.map(service => {
                        const hasGst = service.gst && service.gst > 0;
                        const totalPrice = hasGst ? service.price + service.gst : service.price;

                        return `
                        <div class="group bg-gradient-to-br from-white to-gray-50 border-2 border-gray-200 rounded-xl p-6 hover:shadow-xl hover:border-[#3c5170] transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h3 class="text-xl font-bold text-[#3c5170] group-hover:text-[#2d3e54] transition-colors line-clamp-2">${service.service_name}</h3>
                                    <div class="mt-2">
                                        <div class="flex items-center gap-2">
                                            <span class="text-2xl font-bold text-green-600">$${parseFloat(service.price).toFixed(2)}</span>
                                            <span class="text-sm text-gray-500">base price</span>
                                        </div>
                                        ${hasGst ? `
                                            <div class="mt-1 flex items-center gap-2 text-sm">
                                                <span class="text-blue-600 font-semibold">+ $${parseFloat(service.gst).toFixed(2)} GST (10%)</span>
                                            </div>
                                            <div class="mt-1 pt-1 border-t border-gray-200">
                                                <span class="text-lg font-bold text-[#3c5170]">$${totalPrice.toFixed(2)} total</span>
                                            </div>
                                        ` : ''}
                                    </div>
                                </div>
                                <div class="flex gap-1">
                                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                    <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                                </div>
                            </div>
                            
                            <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">${service.service_desc}</p>
                            
                            ${service.addons && service.addons.length > 0 ? `
                                <div class="mb-4 p-2 bg-blue-50 rounded-lg border border-blue-100">
                                    <div class="flex items-center gap-2 mb-2">
                                        <i class="fa-solid fa-puzzle-piece text-blue-600 text-sm"></i>
                                        <strong class="text-sm font-semibold text-blue-900">Add-ons</strong>
                                    </div>
                                    <ul class="space-y-1">
                                        ${service.addons.map(addon => `
                                            <li class="flex items-center justify-between text-sm text-blue-800">
                                                <div class="flex items-center gap-2">
                                                    <i class="fa-solid fa-check text-xs text-blue-600"></i>
                                                    <span>${addon.name}</span>
                                                </div>
                                                <span class="font-semibold text-green-600">$${parseFloat(addon.price).toFixed(2)}</span>
                                            </li>
                                        `).join('')}
                                    </ul>
                                </div>
                            ` : ''}
                            
                            <div class="flex gap-2 pt-3 border-t border-gray-200">
                                <button onclick="editService(${service.id})" 
                                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                    <i class="fa-solid fa-edit"></i>
                                    <span>Edit</span>
                                </button>
                                <button onclick="deleteService(${service.id})" 
                                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                    <i class="fa-solid fa-trash"></i>
                                    <span>Delete</span>
                                </button>
                            </div>
                        </div>
                    `}).join('');
                }
            })
            .catch(error => {
                console.error('Error loading services:', error);
                const servicesList = document.getElementById('servicesList');
                servicesList.innerHTML = `
                    <div class="col-span-full flex flex-col items-center justify-center py-16">
                        <div class="text-center">
                            <i class="fa-solid fa-exclamation-triangle text-6xl text-red-300 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-600 mb-2">Error Loading Services</h3>
                            <p class="text-gray-400">Please refresh the page to try again</p>
                        </div>
                    </div>
                `;
            });
    }

    // Function to edit service
    function editService(id) {
        fetch(`backend/get-service.php?id=${id}`)
            .then(response => response.json())
            .then(service => {
                const hasGst = service.gst !== null && service.gst > 0;

                const addonsHtml = service.addons && service.addons.length > 0
                    ? service.addons.map((addon, index) =>
                        `<div class="relative flex items-center gap-2">
                        <input type="text" 
                               class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#3c5170] focus:ring-2 focus:ring-[#3c5170]/20 transition-all outline-none addon-name" 
                               value="${addon.name}" 
                               placeholder="Add-on name">
                        <input type="number" 
                               step="0.01" 
                               min="0"
                               class="w-28 px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#3c5170] focus:ring-2 focus:ring-[#3c5170]/20 transition-all outline-none addon-price" 
                               value="${addon.price}"
                               placeholder="Price">
                        <button type="button" 
                                onclick="this.parentElement.remove()" 
                                class="px-3 py-3 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>`
                    ).join('')
                    : `<div class="relative flex items-center gap-2">
                        <input type="text" 
                               class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#3c5170] focus:ring-2 focus:ring-[#3c5170]/20 transition-all outline-none addon-name" 
                               placeholder="e.g., Wax Polish">
                        <input type="number" 
                               step="0.01" 
                               min="0"
                               class="w-28 px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#3c5170] focus:ring-2 focus:ring-[#3c5170]/20 transition-all outline-none addon-price" 
                               placeholder="Price">
                    </div>`;

                Swal.fire({
                    title: '<div class="flex items-center gap-3"><i class="fa-solid fa-edit text-blue-600"></i><span>Edit Service</span></div>',
                    html: `
                <div class="text-left space-y-4 px-2">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-tag text-[#3c5170]"></i> Service Name *
                        </label>
                        <input id="service_name" 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#3c5170] focus:ring-2 focus:ring-[#3c5170]/20 transition-all outline-none" 
                               value="${service.service_name}" 
                               placeholder="e.g., Premium Car Wash">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-dollar-sign text-[#3c5170]"></i> Base Price *
                        </label>
                        <input id="service_price" 
                               type="number" 
                               step="0.01" 
                               min="0"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#3c5170] focus:ring-2 focus:ring-[#3c5170]/20 transition-all outline-none" 
                               value="${service.price}"
                               placeholder="e.g., 48.00"
                               oninput="updateGSTCalculation()">
                    </div>

                    <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4">
                        <div class="flex items-center gap-3 mb-3">
                            <input type="checkbox" 
                                   id="gst_checkbox" 
                                   class="w-5 h-5 text-[#3c5170] border-2 border-gray-300 rounded focus:ring-2 focus:ring-[#3c5170]/20 cursor-pointer"
                                   onchange="updateGSTCalculation()"
                                   ${hasGst ? 'checked' : ''}>
                            <label for="gst_checkbox" class="text-sm font-bold text-gray-700 cursor-pointer">
                                <i class="fa-solid fa-percent text-[#3c5170]"></i> Add 10% GST
                            </label>
                        </div>
                        <div id="gst_display" class="text-sm text-gray-600 ml-8 ${hasGst ? '' : 'hidden'}">
                            <div class="flex justify-between items-center">
                                <span>GST Amount (10%):</span>
                                <span class="font-bold text-green-600">$<span id="gst_amount">${hasGst ? service.gst.toFixed(2) : '0.00'}</span></span>
                            </div>
                            <div class="flex justify-between items-center mt-1 pt-2 border-t border-blue-300">
                                <span class="font-semibold">Total with GST:</span>
                                <span class="font-bold text-[#3c5170] text-lg">$<span id="total_with_gst">${hasGst ? (service.price + service.gst).toFixed(2) : '0.00'}</span></span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-file-text text-[#3c5170]"></i> Service Description *
                        </label>
                        <textarea id="service_desc" 
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#3c5170] focus:ring-2 focus:ring-[#3c5170]/20 transition-all outline-none resize-none" 
                                  rows="4" 
                                  placeholder="Describe your service in detail...">${service.service_desc}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-puzzle-piece text-[#3c5170]"></i> Add-ons (Optional)
                        </label>
                        <div id="addons_container" class="space-y-2">
                            ${addonsHtml}
                        </div>
                        <button type="button" 
                                onclick="addAddonField()" 
                                class="mt-3 w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class="fa-solid fa-plus"></i>
                            <span>Add Another Add-on</span>
                        </button>
                    </div>
                </div>
            `,
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa-solid fa-check mr-2"></i>Update Service',
                    confirmButtonColor: '#3c5170',
                    cancelButtonText: '<i class="fa-solid fa-times mr-2"></i>Cancel',
                    cancelButtonColor: '#6b7280',
                    width: '650px',
                    padding: '2rem',
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl',
                        title: 'text-2xl font-bold text-gray-800',
                        htmlContainer: 'mt-4',
                        confirmButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all',
                        cancelButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all'
                    },
                    preConfirm: () => {
                        const serviceName = document.getElementById('service_name').value.trim();
                        const servicePrice = document.getElementById('service_price').value.trim();
                        const serviceDesc = document.getElementById('service_desc').value.trim();
                        const gstChecked = document.getElementById('gst_checkbox').checked;

                        if (!serviceName || !servicePrice || !serviceDesc) {
                            Swal.showValidationMessage('<i class="fa-solid fa-exclamation-circle mr-2"></i>Please fill in all required fields');
                            return false;
                        }

                        if (parseFloat(servicePrice) < 0) {
                            Swal.showValidationMessage('<i class="fa-solid fa-exclamation-circle mr-2"></i>Price must be greater than or equal to 0');
                            return false;
                        }

                        const addonNames = document.querySelectorAll('.addon-name');
                        const addonPrices = document.querySelectorAll('.addon-price');
                        const addons = [];

                        addonNames.forEach((nameInput, index) => {
                            const name = nameInput.value.trim();
                            const price = addonPrices[index].value.trim();

                            if (name && price) {
                                addons.push({
                                    name: name,
                                    price: parseFloat(price)
                                });
                            }
                        });

                        // Calculate GST if checkbox is checked
                        const gstFee = gstChecked ? parseFloat(servicePrice) * 0.12 : null;

                        return {
                            id: id,
                            service_name: serviceName,
                            service_price: parseFloat(servicePrice),
                            service_desc: serviceDesc,
                            GST_FEE: gstFee,
                            has_gst: gstChecked,
                            addons: addons
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateService(result.value);
                    }
                });
            });
    }

    // Function to update service
    function updateService(data) {
        Swal.fire({
            title: 'Updating...',
            html: '<i class="fa-solid fa-spinner fa-spin text-3xl text-[#3c5170]"></i>',
            showConfirmButton: false,
            allowOutsideClick: false
        });

        fetch('backend/update-service.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '<span class="text-green-600">Updated!</span>',
                        html: '<p class="text-gray-600">Service has been updated successfully</p>',
                        confirmButtonColor: '#3c5170',
                        confirmButtonText: 'Great!',
                        customClass: {
                            popup: 'rounded-2xl'
                        }
                    }).then(() => {
                        loadServices();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '<span class="text-red-600">Error!</span>',
                        html: `<p class="text-gray-600">${result.message || 'Failed to update service'}</p>`,
                        confirmButtonColor: '#3c5170',
                        customClass: {
                            popup: 'rounded-2xl'
                        }
                    });
                }
            });
    }

    // Function to delete service
    function deleteService(id) {
        Swal.fire({
            title: '<span class="text-red-600">Are you sure?</span>',
            html: `
                <div class="text-center py-4">
                    <i class="fa-solid fa-trash-alt text-6xl text-red-400 mb-4"></i>
                    <p class="text-gray-600 text-lg">You won't be able to revert this action!</p>
                    <p class="text-gray-500 text-sm mt-2">This will permanently delete the service and all its add-ons.</p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fa-solid fa-trash mr-2"></i>Yes, delete it!',
            cancelButtonText: '<i class="fa-solid fa-times mr-2"></i>Cancel',
            customClass: {
                popup: 'rounded-2xl shadow-2xl',
                confirmButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all',
                cancelButton: 'px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting...',
                    html: '<i class="fa-solid fa-spinner fa-spin text-3xl text-red-600"></i>',
                    showConfirmButton: false,
                    allowOutsideClick: false
                });

                fetch('backend/delete-service.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: id })
                })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '<span class="text-green-600">Deleted!</span>',
                                html: '<p class="text-gray-600">Service has been deleted successfully</p>',
                                confirmButtonColor: '#3c5170',
                                confirmButtonText: 'OK',
                                customClass: {
                                    popup: 'rounded-2xl'
                                }
                            }).then(() => {
                                loadServices();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '<span class="text-red-600">Error!</span>',
                                html: `<p class="text-gray-600">${result.message || 'Failed to delete service'}</p>`,
                                confirmButtonColor: '#3c5170',
                                customClass: {
                                    popup: 'rounded-2xl'
                                }
                            });
                        }
                    });
            }
        });
    }
</script>

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

    /* Line clamp utilities */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<?php include "includes/footer.php" ?>