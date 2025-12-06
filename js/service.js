// Global services data
let servicesData = [];

// Load services on page load
document.addEventListener("DOMContentLoaded", function () {
  loadServices();
  initializeCalculator();
});

// Function to load services from database
function loadServices() {
  fetch("../admin/backend/get-services.php")
    .then((response) => response.json())
    .then((services) => {
      servicesData = services;
      renderServices(services);
      populateCalculatorServices(services);
    })
    .catch((error) => {
      console.error("Error loading services:", error);
      showErrorState();
    });
}

// Function to render service cards
function renderServices(services) {
  const servicesGrid = document.getElementById("servicesGrid");

  if (services.length === 0) {
    servicesGrid.innerHTML = `
            <div class="col-span-full text-center py-20">
                <i class="fa-solid fa-box-open text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-semibold text-gray-600 mb-2">No Services Available</h3>
                <p class="text-gray-400">Check back soon for our cleaning services</p>
            </div>
        `;
    return;
  }

  servicesGrid.innerHTML = services
    .map((service, index) => {
      const icons = [
        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>',
        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>',
        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>',
      ];
      const icon = icons[index % icons.length];

      return `
            <div class="h-[100%] overflow-y-auto group cursor-pointer bg-white rounded-2xl shadow-md z-30 hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-[#fbb06b] transform hover:-translate-y-2">
                <!-- Service Header -->
                <div class="bg-gradient-to-br from-[#3c5170] to-[#4a6080] p-6 text-white">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-2xl font-bold">${
                          service.service_name
                        }</h3>
                        <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${icon}
                        </svg>
                    </div>
                </div>

                <!-- Service Body -->
                <div class="p-6">
                    <!-- Full Description -->
                    <div class="mb-4">
                        <h4 class="text-sm font-bold text-[#3c5170] mb-2 uppercase tracking-wide flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Service Description
                        </h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            ${
                              service.service_desc ||
                              "Professional cleaning service tailored to your needs. Our experienced team uses high-quality products and equipment to ensure your space is spotlessly clean."
                            }
                        </p>
                    </div>

                    <!-- Available Add-ons -->
                    ${
                      service.addons && service.addons.length > 0
                        ? `
                        <div class="mb-4">
                            <h4 class="text-sm font-bold text-[#3c5170] mb-3 uppercase tracking-wide flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Available Add-ons (${service.addons.length})
                            </h4>
                            <ul class="space-y-2 max-h-48 overflow-y-auto custom-scrollbar">
                                ${service.addons
                                  .map(
                                    (addon) => `
                                    <li class="text-sm text-gray-600 flex items-center justify-between p-2 rounded hover:bg-gray-50 transition-colors">
                                        <div class="flex items-start flex-1">
                                            <span class="text-[#fbb06b] mr-2 font-bold mt-0.5">+</span>
                                            <span>${addon.name}</span>
                                        </div>
                                    </li>
                                `
                                  )
                                  .join("")}
                            </ul>
                        </div>
                    `
                        : `
                        <div class="mb-4 text-center py-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-500 italic">No additional add-ons available for this service</p>
                        </div>
                    `
                    }

                    <!-- Action Button -->
                    <div class="pt-4 border-t border-gray-200">
                        <button onclick='openCalculatorModal(${JSON.stringify(
                          service
                        )})' class="w-full text-white px-4 py-3 rounded-lg text-center font-semibold btn-main transition-all duration-300 flex items-center justify-center">
                            <span>Book This Service</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;
    })
    .join("");
}

// Function to show error state
function showErrorState() {
  const servicesGrid = document.getElementById("servicesGrid");
  servicesGrid.innerHTML = `
        <div class="col-span-full text-center py-20">
            <i class="fa-solid fa-exclamation-triangle text-6xl text-red-300 mb-4"></i>
            <h3 class="text-2xl font-semibold text-gray-600 mb-2">Error Loading Services</h3>
            <p class="text-gray-400 mb-4">We're having trouble loading our services</p>
            <button onclick="loadServices()" class="px-6 py-3 bg-[#3c5170] text-white rounded-lg hover:bg-[#2d3e54] transition-colors">
                Try Again
            </button>
        </div>
    `;
}

// Function to populate calculator dropdown
function populateCalculatorServices(services) {
  const select = document.getElementById("floatingServiceType");
  select.innerHTML = '<option value="">Choose a service...</option>';
  services.forEach((service) => {
    const option = document.createElement("option");
    option.value = service.id;
    option.textContent = service.service_name;
    option.dataset.service = JSON.stringify(service);
    select.appendChild(option);
  });
}

// Function to open calculator modal with pre-selected service
function openCalculatorModal(service) {
  const calcPanel = document.getElementById("calcPanel");
  const modalOverlay = document.getElementById("modalOverlay");

  // Show modal
  calcPanel.classList.add("active");
  modalOverlay.classList.add("active");
  document.body.style.overflow = "hidden";

  // Pre-select the service
  const select = document.getElementById("floatingServiceType");
  select.value = service.id;

  // Disable the dropdown since service is pre-selected
  select.disabled = true;

  // Trigger change event to load add-ons
  const event = new Event("change");
  select.dispatchEvent(event);

  // Reset results
  document.getElementById("floatingResults").style.display = "none";
}

// Function to close calculator modal
function closeCalculatorModal() {
  const calcPanel = document.getElementById("calcPanel");
  const modalOverlay = document.getElementById("modalOverlay");
  const select = document.getElementById("floatingServiceType");

  calcPanel.classList.remove("active");
  modalOverlay.classList.remove("active");
  document.body.style.overflow = "";

  // Re-enable the dropdown
  select.disabled = false;

  // Reset form
  document.getElementById("floatingCalcForm").reset();
  document.getElementById("floatingResults").style.display = "none";
  document.getElementById("floatingDynamicFields").innerHTML = "";
  document.getElementById("floatingExtrasContainer").style.display = "none";
}

// Initialize calculator functionality
function initializeCalculator() {
  const serviceSelect = document.getElementById("floatingServiceType");
  const calcForm = document.getElementById("floatingCalcForm");
  const modalOverlay = document.getElementById("modalOverlay");
  const closeBtn = document.getElementById("closeCalculator");

  // Close modal when clicking overlay
  modalOverlay.addEventListener("click", closeCalculatorModal);

  // Close modal when clicking close button
  closeBtn.addEventListener("click", closeCalculatorModal);

  // Handle service selection
  serviceSelect.addEventListener("change", function () {
    const selectedOption = this.options[this.selectedIndex];
    if (!selectedOption.dataset.service) return;
    const service = JSON.parse(selectedOption.dataset.service);
    loadServiceAddons(service);
  });

  // Handle form submission
  calcForm.addEventListener("submit", function (e) {
    e.preventDefault();
    calculateEstimate();
  });
}

// Function to load service add-ons
function loadServiceAddons(service) {
  const extrasContainer = document.getElementById("floatingExtrasContainer");
  const extrasList = document.getElementById("floatingExtrasList");
  const dynamicFields = document.getElementById("floatingDynamicFields");

  const basePrice = parseFloat(service.price || 0);
  const gstFee = parseFloat(service.gst || 0);
  const totalPrice = basePrice + gstFee;

  dynamicFields.innerHTML = `
    <div class="calc-form-group">
        <div class="bg-gradient-to-br from-[#f0f4f8] to-[#e8eef3] rounded-lg p-4 border-l-4 border-[#3c5170]">
            <h4 class="text-base font-bold text-[#3c5170] mb-2">${
              service.service_name
            }</h4>
            <div class="rounded-lg p-3 space-y-2">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">GST Fee:</span>
                    <span class="font-semibold ${
                      gstFee === 0 ? "text-green-700" : "text-gray-700"
                    }">${
    gstFee === 0 ? "GST FREE" : `$${gstFee.toFixed(2)}`
  }</span>
                </div>
                <div class="border-t border-gray-200 pt-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-700">Total Estimated Price:</span>
                        <span class="text-xl font-bold text-[#3c5170]"> $ ${totalPrice.toFixed(
                          2
                        )}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
  `;

  if (service.addons && service.addons.length > 0) {
    extrasList.innerHTML = service.addons
      .map(
        (addon) => `
            <label class="calc-checkbox-label hover:bg-gray-50 p-2 rounded transition-colors cursor-pointer">
                <input type="checkbox" name="addon" value="${addon.name}" data-price="${addon.price}">
                <div class="flex-1 flex items-center justify-between">
                    <span class="text-sm">${addon.name}</span>
                </div>
            </label>
        `
      )
      .join("");
    extrasContainer.style.display = "block";
  } else {
    extrasContainer.style.display = "none";
  }

  document.getElementById("floatingResults").style.display = "none";
}

// Function to calculate estimate
function calculateEstimate() {
  const serviceSelect = document.getElementById("floatingServiceType");

  const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];

  if (!selectedOption.dataset.service) {
    alert("Please select a service");
    return;
  }

  const service = JSON.parse(selectedOption.dataset.service);
  const basePrice = parseFloat(service.price) || 0;
  const gstFee = parseFloat(service.gst) || 0;

  const checkedAddons = document.querySelectorAll(
    'input[name="addon"]:checked'
  );
  let addonsTotal = 0;
  const addonsList = [];

  checkedAddons.forEach((addon) => {
    const price = parseFloat(addon.dataset.price) || 0;
    addonsTotal += price;
    addonsList.push({
      name: addon.value,
      price: price,
    });
  });

  const subtotal = basePrice + addonsTotal;
  const total = subtotal + gstFee;

  displayResults(service, basePrice, gstFee, addonsList, total);
}

// Function to display results with Book Now button
function displayResults(service, basePrice, gstFee, addons, total) {
  const resultsDiv = document.getElementById("floatingResults");
  const breakdownDiv = document.getElementById("floatingBreakdown");

  let breakdownHTML = `
        <div class="calc-breakdown-row font-main text-xl font-semibold -mb-6">
            <span>${service.service_name}</span>
        </div>
    `;

  if (addons.length > 0) {
    addons.forEach((addon) => {
      breakdownHTML += `
                <div class="calc-breakdown-row -mb-5 font-main ml-4">
                    <span><i class="fa-regular fa-circle text-[5px] mx-1"></i> ${addon.name}</span>
                </div>
            `;
    });
  }

  const subtotal =
    basePrice + addons.reduce((sum, addon) => sum + addon.price, 0);
  breakdownHTML += `
        <div class="calc-breakdown-row subtotal mt-4">
            <span>Subtotal</span>
            <span class="font-semibold">${subtotal.toFixed(2)}</span>
        </div>
        <div class="calc-breakdown-row gst">
            <span>GST Fee</span>
            <span class="font-semibold ${
              gstFee === 0 ? "text-green-700" : ""
            }">${gstFee === 0 ? "GST FREE" : gstFee.toFixed(2)}</span>
        </div>
        <div class="calc-breakdown-row total">
            <span>Total Estimate</span>
            <span>$ ${total.toFixed(2)}</span>
        </div>
        <div class="calc-note">
            <i class="fa-solid fa-info-circle mr-1"></i>
            <strong>Note:</strong> Final quotation will be provided after on-site inspection and assessment.
        </div>
    `;

  breakdownDiv.innerHTML = breakdownHTML;
  resultsDiv.style.display = "block";

  // Store comprehensive booking data with all necessary fields
  const bookingData = {
    id: service.id,
    service_name: service.service_name,
    name: service.service_name, // Add both formats for compatibility
    service_desc: service.service_desc || "",
    price: basePrice,
    basePrice: basePrice, // Keep both formats
    gst: gstFee,
    gstFee: gstFee, // Keep both formats
    addons: addons,
    total: total,
  };

  console.log("Storing booking data:", bookingData); // Debug log
  sessionStorage.setItem("selectedService", JSON.stringify(bookingData));

  // Show Book Now button
  showBookNowButton();

  setTimeout(() => {
    resultsDiv.scrollIntoView({ behavior: "smooth", block: "nearest" });
  }, 100);
}

// Function to show Book Now button after calculation
function showBookNowButton() {
  const resultsDiv = document.getElementById("floatingResults");

  // Check if button already exists
  if (!document.getElementById("bookNowBtn")) {
    const bookNowBtn = document.createElement("button");
    bookNowBtn.id = "bookNowBtn";
    bookNowBtn.className =
      "w-full mt-4 bg-[#3c5170] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#2d3e54] transition-all duration-300 flex items-center justify-center";
    bookNowBtn.innerHTML = `
      <span>Book Now</span>
      <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
      </svg>
    `;
    bookNowBtn.onclick = function () {
      window.location.href = "booking-date.php";
    };
    resultsDiv.appendChild(bookNowBtn);
  }
}

// Add custom scrollbar styles
const scrollbarStyle = document.createElement("style");
scrollbarStyle.textContent = `
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #fbb06b;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #f39c50;
    }
    
    .calc-breakdown-row.subtotal {
        border-top: 1px solid #e5e7eb;
        padding-top: 0.75rem;
        margin-top: 0.5rem;
        font-weight: 600;
        color: #374151;
    }
    
    .calc-breakdown-row.gst {
        color: #6b7280;
        font-size: 0.9rem;
    }
`;
document.head.appendChild(scrollbarStyle);
