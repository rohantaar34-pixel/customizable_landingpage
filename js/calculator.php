<script>
    (function () {
        'use strict';

        // Service configurations (same as main calculator)
        const serviceTypes = {
            'airbnb': {
                name: 'airbnb_cleaning',
                displayName: 'Airbnb Cleaning',
                rateType: 'rooms',
                baseRatePerHour: 83.00,
                minimumHours: 2,
                hasRooms: true,
                hasBathrooms: true,
                hasLivingAreas: true,
                hasExtras: true,
                requiresInspection: false,
                gstRate: 0.10
            },
            'medical': {
                name: 'medical_clinic',
                displayName: 'Medical Clinic Cleaning',
                rateType: 'sqft',
                baseRatePerSqFt: 0.096,
                minimumHours: 2,
                hasSqFt: true,
                hasExtras: false,
                requiresInspection: false,
                gstRate: 0.10
            },
            'residential': {
                name: 'residential',
                displayName: 'Residential Cleaning',
                rateType: 'rooms',
                baseRatePerHour: 160.50,
                minimumHours: 2,
                hasRooms: true,
                hasBathrooms: true,
                hasLivingAreas: true,
                hasExtras: true,
                requiresInspection: false,
                gstRate: 0.10
            },
            'office': {
                name: 'office_commercial',
                displayName: 'Office / Commercial',
                rateType: 'sqft',
                baseRatePerSqFt: 0.096,
                minimumHours: 2,
                hasSqFt: true,
                hasExtras: false,
                requiresInspection: false,
                gstRate: 0.10
            },
            'ndis': {
                name: 'ndis_aged_care',
                displayName: 'NDIS / Aged Care',
                rateType: 'hours',
                baseRatePerHour: 92.00,
                minimumHours: 2,
                hasHours: true,
                hasExtras: true,
                requiresInspection: false,
                gstRate: 0.10
            },
            'moving': {
                name: 'moving_in_out',
                displayName: 'Moving In-Out',
                rateType: 'rooms',
                baseRate: 670.00,
                minimumHours: 2,
                hasRooms: true,
                hasBathrooms: true,
                hasLivingAreas: true,
                hasExtras: true,
                requiresInspection: true,
                gstRate: 0.10
            },
            'lease': {
                name: 'end_of_lease',
                displayName: 'End of Lease',
                rateType: 'rooms',
                baseRate: 705.00,
                minimumHours: 2,
                hasRooms: true,
                hasBathrooms: true,
                hasLivingAreas: true,
                hasExtras: true,
                requiresInspection: true,
                gstRate: 0.10
            },
            'presell': {
                name: 'presell_property',
                displayName: 'Pre-Sell Property',
                rateType: 'rooms',
                baseRate: 415.00,
                minimumHours: 2,
                hasRooms: true,
                hasBathrooms: true,
                hasLivingAreas: true,
                hasExtras: true,
                requiresInspection: true,
                gstRate: 0.10
            }
        };

        const extraServices = {
            'airbnb': [
                { id: 'kitchen_clean', name: 'Kitchen Clean', price: 70.00 }
            ],
            'residential': [
                { id: 'kitchen_clean', name: 'Kitchen Clean', price: 70.00 },
                { id: 'oven_cleaning', name: 'Oven Cleaning', price: 75.00 },
                { id: 'interior_windows', name: 'Interior Windows', price: 80.00 }
            ],
            'ndis': [
                { id: 'wash_dry_laundry', name: 'Laundry Service', price: 30.00 },
                { id: 'accessible_windows', name: 'Window Cleaning', price: 50.00 }
            ],
            'moving': [
                { id: 'full_kitchen_deep', name: 'Kitchen Deep Clean', price: 120.00 },
                { id: 'deep_oven', name: 'Oven Clean', price: 75.00 },
                { id: 'internal_external_windows', name: 'All Windows', price: 150.00 },
                { id: 'carpet_cleaning_2rooms', name: 'Carpet (2 rooms)', price: 110.00 }
            ],
            'lease': [
                { id: 'full_kitchen_deep', name: 'Kitchen Deep Clean', price: 120.00 },
                { id: 'deep_oven', name: 'Oven Clean', price: 75.00 },
                { id: 'internal_external_windows', name: 'All Windows', price: 150.00 },
                { id: 'carpet_cleaning_2rooms', name: 'Carpet (2 rooms)', price: 110.00 }
            ],
            'presell': [
                { id: 'kitchen_clean', name: 'Kitchen Clean', price: 90.00 },
                { id: 'carpet_cleaning_2rooms', name: 'Carpet (2 rooms)', price: 110.00 }
            ]
        };

        // DOM Elements
        const toggle = document.getElementById('calcToggle');
        const panel = document.getElementById('calcPanel');
        const form = document.getElementById('floatingCalcForm');
        const serviceSelect = document.getElementById('floatingServiceType');
        const dynamicFields = document.getElementById('floatingDynamicFields');
        const extrasContainer = document.getElementById('floatingExtrasContainer');
        const extrasList = document.getElementById('floatingExtrasList');
        const results = document.getElementById('floatingResults');
        const breakdown = document.getElementById('floatingBreakdown');

        // Tutorial elements
        const tutorial = document.getElementById('calcTutorial');
        const tutorialStart = document.getElementById('tutorialStart');
        const tutorialSkip = document.getElementById('tutorialSkip');
        const tutorialDontShow = document.getElementById('tutorialDontShow');
        const spotlight = document.getElementById('calcSpotlight');
        const arrow = document.getElementById('calcArrow');
        const hint = document.getElementById('calcHint');

        // Check if tutorial should be shown
        function shouldShowTutorial() {
            return !localStorage.getItem('calcTutorialCompleted');
        }

        // Show tutorial on page load
        function initTutorial() {
            if (shouldShowTutorial()) {
                setTimeout(() => {
                    tutorial.classList.add('active');
                }, 800);
            }
        }

        // Start tutorial - show visual guides
        function startTutorialGuide() {
            tutorial.classList.remove('active');

            // Show visual guides
            setTimeout(() => {
                spotlight.classList.add('active');
                arrow.classList.add('active');
                hint.classList.add('active');

                // Make calculator button pulse
                toggle.style.animation = 'pulse 2s infinite';
            }, 300);

            // Auto-hide guides after 10 seconds
            setTimeout(() => {
                hideVisualGuides();
            }, 10000);
        }

        // Hide visual guides
        function hideVisualGuides() {
            spotlight.classList.remove('active');
            arrow.classList.remove('active');
            hint.classList.remove('active');
            toggle.style.animation = '';
        }

        // Tutorial event listeners
        tutorialStart.addEventListener('click', function () {
            if (tutorialDontShow.checked) {
                localStorage.setItem('calcTutorialCompleted', 'true');
            }
            startTutorialGuide();
        });

        tutorialSkip.addEventListener('click', function () {
            if (tutorialDontShow.checked) {
                localStorage.setItem('calcTutorialCompleted', 'true');
            }
            tutorial.classList.remove('active');
        });

        // Toggle calculator
        toggle.addEventListener('click', function () {
            const isActive = panel.classList.toggle('active');
            toggle.classList.toggle('active');

            // Hide visual guides when calculator is opened
            if (isActive) {
                hideVisualGuides();
                if (serviceSelect.options.length === 1) {
                    initServiceDropdown();
                }
            }
        });

        // Close when clicking outside
        document.addEventListener('click', function (e) {
            if (!panel.contains(e.target) && !toggle.contains(e.target) && !tutorial.contains(e.target)) {
                panel.classList.remove('active');
                toggle.classList.remove('active');
            }
        });

        // Initialize service dropdown
        function initServiceDropdown() {
            serviceSelect.innerHTML = '<option value="">Choose a service...</option>';
            Object.entries(serviceTypes).forEach(([key, service]) => {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = service.displayName;
                serviceSelect.appendChild(option);
            });
        }

        // Render dynamic fields
        function renderDynamicFields(serviceKey) {
            const service = serviceTypes[serviceKey];
            let html = '';

            if (service.hasRooms) {
                html += `
            <div class="calc-form-group">
                <label class="calc-label">Bedrooms</label>
                <input type="number" id="floatingBedrooms" class="calc-input" min="1" max="20" value="1" required>
            </div>`;
            }

            if (service.hasBathrooms) {
                html += `
            <div class="calc-form-group">
                <label class="calc-label">Bathrooms</label>
                <input type="number" id="floatingBathrooms" class="calc-input" min="1" max="10" value="1" required>
            </div>`;
            }

            if (service.hasLivingAreas) {
                html += `
            <div class="calc-form-group">
                <label class="calc-label">Living Areas</label>
                <input type="number" id="floatingLivingAreas" class="calc-input" min="1" max="10" value="1" required>
            </div>`;
            }

            if (service.hasSqFt) {
                html += `
            <div class="calc-form-group">
                <label class="calc-label">Square Feet</label>
                <input type="number" id="floatingSqft" class="calc-input" min="1" max="10000" value="1000" required>
            </div>`;
            }

            if (service.hasHours) {
                html += `
            <div class="calc-form-group">
                <label class="calc-label">Estimated Hours</label>
                <input type="number" id="floatingHours" class="calc-input" min="2" max="24" value="2" step="0.5" required>
            </div>`;
            }

            dynamicFields.innerHTML = html;
        }

        // Render extras
        function renderExtraServices(serviceKey) {
            const extras = extraServices[serviceKey];

            if (!extras || extras.length === 0) {
                extrasContainer.style.display = 'none';
                return;
            }

            extrasContainer.style.display = 'block';
            extrasList.innerHTML = extras.map(extra => `
        <label class="calc-checkbox-label">
            <input type="checkbox" name="floatingExtras" value="${extra.id}" data-price="${extra.price}">
            <span>${extra.name} <span style="color: #6b7280;">(+${extra.price.toFixed(2)})</span></span>
        </label>
    `).join('');
        }

        // Calculate estimate
        function calculateEstimate(serviceKey, formData) {
            const service = serviceTypes[serviceKey];
            let subtotal = 0;
            let details = { bedrooms: 0, bathrooms: 0, livingAreas: 0, sqft: 0, hours: 0, extras: [] };

            switch (service.rateType) {
                case 'rooms':
                    details.bedrooms = parseInt(formData.bedrooms) || 1;
                    details.bathrooms = parseInt(formData.bathrooms) || 1;
                    details.livingAreas = parseInt(formData.livingAreas) || 1;
                    subtotal = service.baseRate || (service.baseRatePerHour * service.minimumHours);
                    break;
                case 'sqft':
                    details.sqft = parseInt(formData.sqft) || 1000;
                    subtotal = details.sqft * service.baseRatePerSqFt;
                    break;
                case 'hours':
                    details.hours = parseFloat(formData.hours) || 2;
                    subtotal = details.hours * service.baseRatePerHour;
                    break;
            }

            const checkedExtras = document.querySelectorAll('input[name="floatingExtras"]:checked');
            checkedExtras.forEach(checkbox => {
                const price = parseFloat(checkbox.dataset.price);
                const name = checkbox.nextElementSibling.textContent.split('(+')[0].trim();
                details.extras.push({ name, price });
            });

            const extrasTotal = details.extras.reduce((sum, extra) => sum + extra.price, 0);
            const finalSubtotal = subtotal + extrasTotal;
            const gst = finalSubtotal * service.gstRate;
            const total = finalSubtotal + gst;

            return { service, details, subtotal, extrasTotal, gst, total };
        }

        // Display results
        function displayResults(calc) {
            let html = `
        <div class="calc-breakdown-row">
            <span>Subtotal</span>
            <span>${calc.subtotal.toFixed(2)}</span>
        </div>`;

            calc.details.extras.forEach(extra => {
                html += `
            <div class="calc-breakdown-row" style="font-size: 0.85rem; color: #6b7280;">
                <span>↳ ${extra.name}</span>
                <span>${extra.price.toFixed(2)}</span>
            </div>`;
            });

            html += `
        <div class="calc-breakdown-row">
            <span>GST (10%)</span>
            <span>${calc.gst.toFixed(2)}</span>
        </div>
        <div class="calc-breakdown-row total">
            <span>Total</span>
            <span>${calc.total.toFixed(2)}</span>
        </div>`;

            if (calc.service.requiresInspection) {
                html += `<div class="calc-note"><strong>Note:</strong> This service requires a FREE site inspection for final quote.</div>`;
            } else {
                html += `<div class="calc-disclaimer">*Estimate may vary based on property condition</div>`;
            }

            breakdown.innerHTML = html;
            results.style.display = 'block';
        }

        // Event listeners
        serviceSelect.addEventListener('change', function () {
            const serviceKey = this.value;
            if (!serviceKey) {
                dynamicFields.innerHTML = '';
                extrasContainer.style.display = 'none';
                results.style.display = 'none';
                return;
            }
            renderDynamicFields(serviceKey);
            renderExtraServices(serviceKey);
            results.style.display = 'none';
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const serviceKey = serviceSelect.value;
            if (!serviceKey) return;

            const formData = {
                bedrooms: document.getElementById('floatingBedrooms')?.value,
                bathrooms: document.getElementById('floatingBathrooms')?.value,
                livingAreas: document.getElementById('floatingLivingAreas')?.value,
                sqft: document.getElementById('floatingSqft')?.value,
                hours: document.getElementById('floatingHours')?.value
            };

            const calc = calculateEstimate(serviceKey, formData);
            displayResults(calc);

            // Auto-scroll to results after a brief delay
            setTimeout(() => {
                results.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 100);
        });

        // Initialize tutorial
        initTutorial();
    })();

</script>