<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        /* File listing styles */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 20px;
            overflow-x: hidden;
        }

        .timestamp {
            color: #666;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-header {
            font-size: 14px;
            color: #333;
            margin-bottom: 15px;
        }

        .file-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .file-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            background: white;
            padding: 12px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            cursor: pointer;
        }

        .file-icon {
            width: 40px;
            height: 40px;
            background: #f0f0f0;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .file-details {
            flex-grow: 1;
        }

        .file-name {
            font-size: 14px;
            color: #333;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .file-subtitle {
            font-size: 12px;
            color: #666;
            margin-bottom: 4px;
        }

        .file-tags {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 4px;
        }

        .tag {
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            background: #e8f5e9;
            color: #2e7d32;
            white-space: nowrap;
        }

        .file-size {
            font-size: 12px;
            color: #d32f2f;
        }

        .separator {
            height: 1px;
            background: #e0e0e0;
            margin: 25px 0;
        }

        /* Modal/Popup Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 1000;
        }

        .modal {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            background: white;
            transform: translateY(100%);
            transition: transform 0.3s ease-out;
            z-index: 1001;
            height: 95vh;
            overflow-y: auto;
        }

        .modal.show {
            transform: translateY(0);
        }

        .modal-header {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            text-align: right;
            position: sticky;
            top: 0;
            background: white;
            z-index: 2;
        }

        .close-button {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            color: #666;
        }

        .modal-content {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Floor Plan Specific Styles */
        .corner-label {
            position: absolute;
            top: 0;
            right: 0;
            background: #D4C5B3;
            color: #333;
            padding: 8px 16px;
            font-size: 20px;
            font-weight: bold;
        }

        .floor-plan-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
            margin-top: 20px;
            color: #333;
            position: relative;
        }

        .type-details {
            margin-bottom: 30px;
        }

        .type-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .type-specs {
            color: #666;
            margin-bottom: 5px;
        }

        .unit-blocks {
            margin-bottom: 5px;
        }

        .unit-block {
            color: #666;
            line-height: 1.6;
        }

        .floor-plans {
            display: flex;
            gap: 30px;
            margin: 30px 0;
        }

        .floor-plan {
            flex: 1;
            border: 1px solid #ddd;
            padding: 10px;
        }

        .floor-plan img {
            width: 100%;
            height: auto;
        }

        .legend-section {
            margin-top: 40px;
        }

        .legend-title {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .legend-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            margin-bottom: 30px;
        }

        .legend-item {
            display: flex;
            gap: 15px;
            font-size: 13px;
            color: #666;
        }

        .legend-key {
            font-weight: 500;
            min-width: 30px;
        }

        .scale-section {
            margin: 30px 0;
            text-align: center;
        }

        .scale-line {
            width: 100%;
            height: 2px;
            background: #333;
            position: relative;
            margin: 20px 0;
        }

        .scale-marker {
            position: absolute;
            bottom: 5px;
            transform: translateX(-50%);
            font-size: 12px;
        }

        .notes {
            font-size: 11px;
            color: #666;
            line-height: 1.4;
        }

        .key-plan {
            margin-top: 30px;
            text-align: right;
        }

        .key-plan img {
            max-width: 200px;
        }

        .table-section {
            margin-top: 40px;
            font-size: 13px;
        }

        .table-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .table-label {
            color: #666;
        }

        .table-value {
            font-weight: 500;
        }

    </style>
</head>
<body>
    <!-- Original file listing content remains the same -->
    <div class="timestamp">Generated Time: <?= date('d/m/Y h:i:s A'); ?></div>

    <!-- File listing sections -->
    <div class="section">
        <div class="section-header">Based on Price, below are the cheapest tests you can consider:</div>
        <div class="file-list" id="section-1">
        </div>
    </div>

    <!-- File listing sections -->
    <div class="section">
        <div class="section-header">Based on PSF, below are the units you can consider:</div>
        <div class="file-list" id="section-2">
        </div>
    </div>

    <!-- File listing sections -->
    <div class="section">
        <div class="section-header">Based on Size, we sorted these to be best fit. Based on the smallest size:</div>
        <div class="file-list" id="section-3">
        </div>
    </div>

    <!-- File listing sections -->
    <div class="section">
        <div class="section-header">Based on Size, we sorted these to be best fit. Based on the largest size:</div>
        <div class="file-list" id="section-4">
        </div>
    </div>

    <!-- File listing sections -->
    <div class="section">
        <div class="section-header">Based on Floor level, we sorted these to be best fit.</div>
        <div class="file-list" id="section-5">
        </div>
    </div>

    <!-- Modal/Popup for Floor Plan -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal" id="floorPlanModal">
            <div class="modal-header">
                <button class="close-button" onclick="hideFloorPlan()">×</button>
            </div>
            <div class="modal-content">
                <!-- <div class="corner-label">3-BEDROOM<br>+ STUDY</div> -->
                
                <!-- Type C2-G Section -->
                <!-- <div class="type-details">
                    <div class="type-title">TYPE C2-G</div>
                    <div class="type-specs">82 sqm / 883 sqft</div>
                    <div class="type-specs">(Inclusive of 6sqm PES)</div>
                    <div class="unit-blocks">
                        <div class="unit-block">BLOCK 6 &nbsp;&nbsp;&nbsp; #01-01, #01-03</div>
                        <div class="unit-block">BLOCK 8 &nbsp;&nbsp;&nbsp; #01-05, #01-07</div>
                        <div class="unit-block">BLOCK 10 &nbsp;&nbsp; #01-09</div>
                        <div class="unit-block">BLOCK 16 &nbsp;&nbsp; #01-23</div>
                        <div class="unit-block">BLOCK 18 &nbsp;&nbsp; #01-25, #01-27</div>
                    </div>
                </div> -->

                <!-- Type C2 Section -->
                <!-- <div class="type-details">
                    <div class="type-title">TYPE C2</div>
                    <div class="type-specs">82 sqm / 883 sqft</div>
                    <div class="type-specs">(Inclusive of 6sqm Balcony)</div>
                    <div class="unit-blocks">
                        <div class="unit-block">BLOCK 6 &nbsp;&nbsp;&nbsp; #02-01 TO #18-01</div>
                        <div class="unit-block">BLOCK 6 &nbsp;&nbsp;&nbsp; #02-03 TO #18-03</div>
                        <div class="unit-block">BLOCK 6 &nbsp;&nbsp;&nbsp; #02-05 TO #18-05</div>
                        <div class="unit-block">BLOCK 8 &nbsp;&nbsp;&nbsp; #02-07 TO #18-07</div>
                        <div class="unit-block">BLOCK 10 &nbsp;&nbsp; #02-09 TO #18-09</div>
                        <div class="unit-block">BLOCK 16 &nbsp;&nbsp; #02-23 TO #18-23</div>
                        <div class="unit-block">BLOCK 18 &nbsp;&nbsp; #02-25 TO #18-25</div>
                        <div class="unit-block">BLOCK 18 &nbsp;&nbsp; #02-27 TO #18-27</div>
                    </div>
                </div> -->

                <!-- Floor Plans -->
                <div class="floor-plans">
                    <img src="" alt="Floor Plan" style="width: 100%; height: auto;" id="floor-plan-image">
                </div>

                <!-- Legend -->
                <!-- <div class="legend-section">
                    <div class="legend-title">LEGEND</div>
                    <div class="legend-grid">
                        <div class="legend-item">
                            <span class="legend-key">F</span>
                            <span>FRIDGE (NOT INCLUDED)</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-key">W</span>
                            <span>WASHER (NOT INCLUDED)</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-key">DB</span>
                            <span>DISTRIBUTION BOARD</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-key">HS</span>
                            <span>HOUSEHOLD SHELTER</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-key">WC</span>
                            <span>WATER CLOSET</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-key">PES</span>
                            <span>PRIVATE ENCLOSED SPACE</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-key">AC</span>
                            <span>AIR-CONDITIONER LEDGE (NON-STRATA)</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-key">RC</span>
                            <span>REINFORCED CONCRETE LEDGE (NON-STRATA)</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-key">☐</span>
                            <span>VOID SPACE (NON-STRATA)</span>
                        </div>
                    </div>
                </div> -->

                <!-- Scale -->
                <!-- <div class="scale-section">
                    <div class="scale-line">
                        <span class="scale-marker" style="left: 0">0</span>
                        <span class="scale-marker" style="left: 25%">2.5m</span>
                        <span class="scale-marker" style="left: 50%">5m</span>
                        <span class="scale-marker" style="left: 75%">7.5m</span>
                        <span class="scale-marker" style="left: 100%">10m</span>
                    </div>
                </div> -->

                <!-- Key Plan -->
                <!-- <div class="key-plan">
                    <img src="" alt="Key Plan">
                    <div>KEY PLAN</div>
                </div> -->

                <!-- Notes -->
                <!-- <div class="notes">
                    ALL PLANS ARE SUBJECT TO CHANGES BY THE RELEVANT AUTHORITIES.<br>
                    MEASUREMENTS ARE APPROXIMATE ONLY AND SUBJECT TO FINAL SURVEY.<br>
                    CO APPROVAL NO. E20250456-UO-50002-CC00562 DATED 03 SEPT 2024
                </div> -->

                <!-- Additional Information Table -->
                <div class="table-section">
                    <div class="table-row">
                        <div class="table-label">Project Name</div>
                        <div class="table-value" id="project-name-value">-</div>
                    </div>
                    <div class="table-row">
                        <div class="table-label">Area/Sqft/Sqm</div>
                        <div class="table-value" id="area-value">-</div>
                    </div>
                    <div class="table-row">
                        <div class="table-label">NPS Price</div>
                        <div class="table-value" id="nps-price-value">-</div>
                    </div>
                    <div class="table-row">
                        <div class="table-label">DPS Price</div>
                        <div class="table-value" id="dps-price-value">-</div>
                    </div>
                    <div class="table-row">
                        <div class="table-label">PSF</div>
                        <div class="table-value" id="psf-value">-</div>
                    </div>
                    <div class="table-row">
                        <div class="table-label">PSM</div>
                        <div class="table-value" id="psm-value">-</div>
                    </div>
                    <div class="table-row">
                        <div class="table-label">Bedrooms</div>
                        <div class="table-value" id="bedrooms-value">-</div>
                    </div>
                    <div class="table-row">
                        <div class="table-label">Bathrooms</div>
                        <div class="table-value" id="bathrooms-value">-</div>
                    </div>
                    <div class="table-row">
                        <div class="table-label">Floor Plan</div>
                        <div class="table-value" id="floor-plan-value">-</div>
                    </div>
                    <div class="table-row">
                        <div class="table-label">Floor</div>
                        <div class="table-value" id="floor-value">-</div>
                    </div>
                    <div class="table-row">
                        <div class="table-label">Type</div>
                        <div class="table-value" id="type-value">-</div>
                    </div>
                    <div class="table-row">
                        <div class="table-label">Block</div>
                        <div class="table-value" id="block-value">-</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const files = [
            { // 0
                id: 0,
                name: "#02-12",
                subtitle: "Novo Place",
                area: "872",
                bedroom: "3",
                floor: "02",
                district: "D24",
                price: "$1328000 / $1522.94 psf",
                image: './singmap-congratulation/listing-0.png',
                // area: '872/81',
                npsPrice: '$1,328,000',
                dpsPrice: '$1,368,000',
                psf: '$1,523',
                psm: '$116,393',
                bedrooms: '3',
                bathrooms: '2',
                floorPlan: 'C1',
                type: '3 Bedroom',
                block: 'Blk 10',
            },
            { // 1
                id: 1,
                name: "#02-14",
                subtitle: "Lumina Grand 昱丰嘉园",
                area: "936",
                bedroom: "3",
                floor: "02",
                district: "D23",
                price: "$1364000 / $1457.26 psf",
                image: './singmap-congratulation/listing-1.png',
                npsPrice: '$1,364,000',
                dpsPrice: '$1,405,000',
                psf: '$1,457',
                psm: '$15,686',
                bedrooms: 3,
                bathrooms: 2,
                floorPlan: 'A2',
                type: '3 Bedroom',
                block: 'Blk 9',
            },
            { // 2
                id: 2,
                name: "#02-21",
                subtitle: "Altura 雅乐轩",
                area: "1539",
                bedroom: "5",
                floor: "02",
                district: "D23",
                price: "$2210000 / $1436 psf",
                image: './singmap-congratulation/listing-2.png',
                npsPrice: '$2,210,000',
                dpsPrice: '$2,276,000',
                psf: '$1,436',
                psm: '$15,457',
                bedrooms: 5,
                bathrooms: 4,
                floorPlan: 'E1',
                type: '5 Bedroom Premium + Flexi',
                block: 'Blk 121',
            },
            { // 3
                id: 3,
                name: "#03-07",
                subtitle: "Lumina Grand 昱丰嘉园",
                area: "1496",
                bedroom: "5",
                floor: "02",
                district: "D23",
                price: "$2130000 / $1423,8 psf",
                image: './singmap-congratulation/listing-3.png',
                npsPrice: '$2,130,000',
                dpsPrice: '$2,194,000',
                psf: '$1,424',
                psm: '$15,326',
                bedrooms: 5,
                bathrooms: 3,
                floorPlan: 'C1',
                type: '5 Bedroom',
                block: 'Blk 5',
            },
            { // 4
                id: 4,
                name: "#14-34",
                subtitle: "Aurelle Of Tampines 晶莹轩",
                area: "840",
                bedroom: "3",
                floor: "14",
                district: "D18",
                price: "$0 / $0 psf",
                image: './singmap-congratulation/listing-4.png',
                npsPrice: null,
                dpsPrice: null,
                psf: null,
                psm: null,
                bedrooms: 3,
                bathrooms: 2,
                floorPlan: 'C1',
                type: '3 Bedroom',
                block: 'Blk 57',
            },
            { // 5
                id: 5,
                name: "#02-05",
                subtitle: "Novo Place",
                area: "883",
                bedroom: "3",
                floor: "02",
                district: "D24",
                price: "$1379000 / $1561.72 psf",
                image: './singmap-congratulation/listing-5.png',
                npsPrice: '$1,379,000',
                dpsPrice: '$1,421,000',
                psf: '$1,562',
                psm: '$16,811',
                bedrooms: 3,
                bathrooms: 2,
                floorPlan: 'C2',
                type: '3 Bedroom + Study',
                block: 'Blk 8',
            },
            { // 6
                id: 6,
                name: "#01-30",
                subtitle: "Aurelle Of Tampines 晶莹轩",
                area: "1356",
                bedroom: "5",
                floor: "01",
                district: "D18",
                price: "$0 / $0 psf",
                image: './singmap-congratulation/listing-6.png',
                npsPrice: null,
                dpsPrice: null,
                psf: null,
                psm: null,
                bedrooms: 5,
                bathrooms: 3,
                floorPlan: 'E1(p)',
                type: '5 Bedroom',
                block: 'Blk 55',
            },
            { // 7
                id: 7,
                name: "#01-12",
                subtitle: "Novo Place",
                area: "872",
                bedroom: "3",
                floor: "01",
                district: "D24",
                price: "$1333000 / $1528,67 psf",
                image: './singmap-congratulation/listing-7.png',
                npsPrice: '$1,333,000',
                dpsPrice: '$1,373,000',
                psf: '$1,529',
                psm: '$16,455',
                bedrooms: 3,
                bathrooms: 2,
                floorPlan: 'C1-G',
                type: '3 Bedroom',
                block: 'Blk 10',
            },
            { // 8
                id: 8,
                name: "#01-10",
                subtitle: "Lumina Grand 昱丰嘉园",
                area: "936",
                bedroom: "3",
                floor: "01",
                district: "D23",
                price: "$1382000 / $1476,5 psf",
                image: './singmap-congratulation/listing-8.png',
                npsPrice: '$1,382,000',
                dpsPrice: '$1,424,000',
                psf: '$1,476',
                psm: '$15,893',
                bedrooms: 3,
                bathrooms: 2,
                floorPlan: 'A2-P',
                type: '3 Bedroom',
                block: 'Blk 7',
            },
            { // 9
                id: 9,
                name: "#01-21",
                subtitle: "Altura 雅乐轩",
                area: "1539",
                bedroom: "5",
                floor: "01",
                district: "D23",
                price: "$2227000 / $1447,04 psf",
                image: './singmap-congratulation/listing-9.png',
                npsPrice: '$2,227,000',
                dpsPrice: '$2,294,000',
                psf: '$1,447',
                psm: '$15,576',
                bedrooms: 5,
                bathrooms: 3,
                floorPlan: 'E1(p)',
                type: '5 Bedroom Premium + Flexi',
                block: 'Blk 121',
            },
            { // 10
                id: 10, 
                name: "#14-27",
                subtitle: "Aurelle Of Tampines 晶莹轩",
                area: "1356",
                bedroom: "3",
                floor: "14",
                district: "D18",
                price: "$0 / $0 psf",
                image: './singmap-congratulation/listing-10.png',
                npsPrice: null,
                dpsPrice: null,
                psf: null,
                psm: null,
                bedrooms: 5,
                bathrooms: 3,
                floorPlan: 'E1',
                type: '5 Bedroom',
                block: 'Blk 53',
            },
        ];

        function createItem(file) {
            return `
                <div class="file-item" onclick="showFloorPlan(${file?.id ?? null})">
                    <div class="file-icon" style="padding: 10px;">
                        ${file.image ? `<img src="${file.image}" style="width: 100%;">` : `📄`}
                    </div>
                    <div class="file-details">
                        <div class="file-name">${file.name}</div>
                        <div class="file-subtitle">${file.subtitle}</div>
                        <div class="file-tags">
                            <span class="tag">Area: ${file.area}</span>
                            <span class="tag">${file.bedroom} Bedroom</span>
                            <span class="tag">Floor: ${file.floor}</span>
                            <span class="tag">District: ${file.district}</span>
                        </div>
                        <div class="file-size">${file.price}</div>
                    </div>
                </div>
            `;
        }

        document.addEventListener("DOMContentLoaded", function () {
            const section1 = document.getElementById("section-1");
            section1.innerHTML += createItem(files[0]);
            section1.innerHTML += createItem(files[1]);
            section1.innerHTML += createItem(files[2]);
            
            const section2 = document.getElementById("section-2");
            section2.innerHTML += createItem(files[3]);
            section2.innerHTML += createItem(files[2]);
            section2.innerHTML += createItem(files[0]);
            
            const section3 = document.getElementById("section-3");
            section3.innerHTML += createItem(files[4]);
            section3.innerHTML += createItem(files[0]);
            section3.innerHTML += createItem(files[1]);
            section3.innerHTML += createItem(files[2]);

            const section4 = document.getElementById("section-4");
            section4.innerHTML += createItem(files[2]);
            section4.innerHTML += createItem(files[3]);
            section4.innerHTML += createItem(files[10]);
            section4.innerHTML += createItem(files[5]);

            const section5 = document.getElementById("section-5");
            section5.innerHTML += createItem(files[6]);
            section5.innerHTML += createItem(files[7]);
            section5.innerHTML += createItem(files[8]);
            section5.innerHTML += createItem(files[9]);

        });

        function showFloorPlan(fileId) {
            document.getElementById("floor-plan-image").src = files[fileId]?.image;
            document.getElementById("project-name-value").innerHTML = files[fileId]?.subtitle ?? '-';
            document.getElementById("area-value").innerHTML = files[fileId]?.area ?? '-';
            document.getElementById("nps-price-value").innerHTML = files[fileId]?.npsPrice ?? '-';
            document.getElementById("dps-price-value").innerHTML = files[fileId]?.dpsPrice ?? '-';
            document.getElementById("psf-value").innerHTML = files[fileId]?.psf ?? '-';
            document.getElementById("psm-value").innerHTML = files[fileId]?.psm ?? '-';
            document.getElementById("bedrooms-value").innerHTML = files[fileId]?.bedrooms ?? '-';
            document.getElementById("bathrooms-value").innerHTML = files[fileId]?.bathrooms ?? '-';
            document.getElementById("floor-plan-value").innerHTML = files[fileId]?.floorPlan ?? '-';
            document.getElementById("floor-value").innerHTML = files[fileId]?.floor ?? '-';
            document.getElementById("type-value").innerHTML = files[fileId]?.type ?? '-';
            document.getElementById("block-value").innerHTML = files[fileId]?.block ?? '-';

            document.getElementById('modalOverlay').style.display = 'block';
            setTimeout(() => {
                document.getElementById('floorPlanModal').classList.add('show');
            }, 10);
            document.body.style.overflow = 'hidden';
        }

        function hideFloorPlan() {
            document.getElementById('floorPlanModal').classList.remove('show');
            setTimeout(() => {
                document.getElementById('modalOverlay').style.display = 'none';
            }, 300);
            document.body.style.overflow = '';
        }

        document.getElementById('modalOverlay').addEventListener('click', (e) => {
            if (e.target === e.currentTarget) {
                hideFloorPlan();
            }
        });
    </script>
</body>