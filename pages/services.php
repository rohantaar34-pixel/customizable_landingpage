<?php
include "includes/config.php";
$conn = conn();
?>
<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>
<?php include "backend/select-homepage.php" ?>

<section class="relative overflow-hidden hero-section min-h-screen flex flex-col w-full justify-center items-center">
    <div class="relative z-50 max-w-7xl mx-auto mb-12 text-center bg-white/60 p-5 rounded shadow-xl mt-10">
        <h1 class="text-5xl font-bold text-[#3c5170] mb-4">Cleaning Services</h1>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">Professional cleaning solutions tailored to your needs.
            Select a service below to get an instant quote.</p>
    </div>

    <div class="w-[80%] md:p-10 p-3">
        <div class="w-full z-50">
            <div class="max-w-7xl mx-auto z-50">
                <!-- Services Grid -->
                <div id="servicesGrid" class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                    <!-- Loading Skeletons -->
                    <div class="skeleton h-96"></div>
                    <div class="skeleton h-96"></div>
                    <div class="skeleton h-96"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Overlay -->
    <div id="modalOverlay" class="calculator-modal-overlay"></div>

    <!-- Calculator Modal -->
    <div class="calculator-modal" id="calcPanel">
        <div class="calculator-modal-content">
            <!-- Close Button -->
            <button class="calculator-close-btn" id="closeCalculator" aria-label="Close Calculator">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <div class="calculator-header">
                <h3>Service Estimator</h3>
                <p>Get an instant estimate for your cleaning needs</p>
            </div>

            <div class="calculator-body">
                <form id="floatingCalcForm">
                    <!-- Service Type -->
                    <div class="calc-form-group">
                        <label class="calc-label">Select Service</label>
                        <select id="floatingServiceType" class="calc-select" required>
                            <option value="">Choose a service...</option>
                        </select>
                    </div>

                    <!-- Dynamic Fields Container -->
                    <div id="floatingDynamicFields"></div>

                    <!-- Extra Services -->
                    <div id="floatingExtrasContainer" style="display:none;" class="calc-extras-box">
                        <label class="calc-extras-label">Optional Add-ons</label>
                        <div id="floatingExtrasList" class="calc-checkbox-group"></div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="calc-btn">Calculate Estimate</button>
                </form>

                <!-- Results -->
                <div id="floatingResults" style="display:none;" class="calc-results">
                    <h4>Your Estimate</h4>
                    <div id="floatingBreakdown" class="calc-breakdown"></div>
                </div>
            </div>
        </div>
    </div>

    <?php include "includes/footer.php" ?>
</section>

<style>
    /* Modal Overlay */
    .calculator-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .calculator-modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    /* Calculator Modal */
    .calculator-modal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.9);
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .calculator-modal.active {
        opacity: 1;
        visibility: visible;
        transform: translate(-50%, -50%) scale(1);
    }

    .calculator-modal-content {
        display: flex;
        flex-direction: column;
        height: 100%;
        max-height: 90vh;
    }

    /* Close Button */
    .calculator-close-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .calculator-close-btn:hover {
        background: white;
        transform: rotate(90deg);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .calculator-close-btn svg {
        width: 20px;
        height: 20px;
        color: #3c5170;
    }

    /* Calculator Header */
    .calculator-header {
        background: linear-gradient(135deg, #3c5170 0%, #4a6080 100%);
        color: white;
        padding: 30px 25px 25px;
        border-radius: 20px 20px 0 0;
    }

    .calculator-header h3 {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .calculator-header p {
        font-size: 0.95rem;
        opacity: 0.9;
        margin: 0;
    }

    /* Calculator Body */
    .calculator-body {
        padding: 25px;
        overflow-y: auto;
        flex: 1;
    }

    /* Form Styles */
    .calc-form-group {
        margin-bottom: 20px;
    }

    .calc-label {
        display: block;
        font-weight: 600;
        color: #3c5170;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .calc-select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.2s ease;
        background: white;
    }

    .calc-select:focus {
        outline: none;
        border-color: #fbb06b;
        box-shadow: 0 0 0 3px rgba(251, 176, 107, 0.1);
    }

    /* Extras Box */
    .calc-extras-box {
        margin: 20px 0;
        padding: 15px;
        background: #f9fafb;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
    }

    .calc-extras-label {
        display: block;
        font-weight: 600;
        color: #3c5170;
        margin-bottom: 12px;
        font-size: 0.95rem;
    }

    .calc-checkbox-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .calc-checkbox-label {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        padding: 10px;
        border-radius: 8px;
        transition: background 0.2s ease;
    }

    .calc-checkbox-label input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #3c5170;
    }

    /* Calculate Button */
    .calc-btn {
        width: 100%;
        padding: 14px 20px;
        background: linear-gradient(135deg, #3c5170 0%, #4a6080 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1.05rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(60, 81, 112, 0.2);
    }

    .calc-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(60, 81, 112, 0.3);
    }

    /* Results */
    .calc-results {
        margin-top: 25px;
        padding: 20px;
        background: #f9fafb;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
    }

    .calc-results h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #3c5170;
        margin: 0 0 15px 0;
    }

    .calc-breakdown {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .calc-breakdown-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
    }

    .calc-breakdown-row.total {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 2px solid #3c5170;
        font-size: 1.25rem;
        font-weight: 700;
        color: #3c5170;
    }

    .calc-note {
        margin-top: 15px;
        padding: 12px;
        background: #fff3cd;
        border-left: 4px solid #fbb06b;
        border-radius: 8px;
        font-size: 0.9rem;
        color: #856404;
        line-height: 1.5;
    }

    /* Responsive */
    @media (max-width: 640px) {
        .calculator-modal {
            width: 95%;
            max-height: 95vh;
        }

        .calculator-header {
            padding: 25px 20px 20px;
        }

        .calculator-header h3 {
            font-size: 1.5rem;
        }

        .calculator-body {
            padding: 20px;
        }
    }
</style>