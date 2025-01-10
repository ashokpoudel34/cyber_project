<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geolocation and Security Tool</title>
    <style>
        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #ff7eb3, #ff758c, #ff9470);
            color: #333;
            overflow-y: scroll; /* Enable body scrolling */
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            background: linear-gradient(135deg, #ffffff, #f0f0f0);
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 95%;
            max-width: 500px;
            text-align: center;
            position: relative;
            overflow: hidden; /* Prevent internal scroll */
        }

        h1 {
            font-size: 2rem;
            color: #ff6f61;
            margin-bottom: 1.5rem;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: 0.3s ease;
        }

        input[type="text"]:hover {
            border-color: #ff6f61;
        }

        .feature {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .feature input[type="checkbox"] {
            margin-right: 10px;
        }

        .feature label {
            font-size: 1rem;
            color: #333;
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #ff6f61, #ff9068);
            border: none;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s ease;
        }

        button:hover {
            background: linear-gradient(135deg, #ff9068, #ff6f61);
        }

        .result-container {
            margin-top: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 10px;
            text-align: left;
            font-size: 0.9em;
            color: #555;
            max-height: 300px; /* Limit max height of the result container */
            overflow-y: auto; /* Enable vertical scrolling within results */
            width: 100%; /* Ensure result container takes full width */
        }

        .result-container h2 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #333;
        }

        .result-container pre {
            background: #f4f4f4;
            padding: 10px;
            border-radius: 8px;
            overflow-x: auto;
        }

        @media (max-width: 600px) {
            .container {
                width: 100%;
                padding: 15px;
            }
        }
    </style>
<script>
function updatePlaceholder() {
    var defaultInput = document.getElementById('defaultInput');
    var geolocationInput = document.getElementById('geolocationInput');
    var nmapInput = document.getElementById('nmapInput');
    var gobusterInput = document.getElementById('gobusterInput');
    var gobustersubdomainInput = document.getElementById('gobustersubdomainInput');
    var dirbInput = document.getElementById('dirbInput');
    var domainInput = document.getElementById('domainInput');

    geolocationInput.style.display = 'none';
    nmapInput.style.display = 'none';
    gobusterInput.style.display = 'none';
    gobustersubdomainInput.style.display = 'none';
    dirbInput.style.display = 'none';
    domainInput.style.display = 'none';
    defaultInput.style.display = 'block';

    if (document.getElementById('geolocation').checked) {
        geolocationInput.style.display = 'block';
        defaultInput.style.display = 'none';
    } else if (document.getElementById('nmap').checked) {
        nmapInput.style.display = 'block';
        defaultInput.style.display = 'none';
    } else if (document.getElementById('gobuster').checked) {
        gobusterInput.style.display = 'block';
        defaultInput.style.display = 'none';
    } else if (document.getElementById('gobustersubdomain').checked) {
        gobustersubdomainInput.style.display = 'block';
        defaultInput.style.display = 'none';
    } else if (document.getElementById('dirb').checked) {
        dirbInput.style.display = 'block';
        defaultInput.style.display = 'none';
    } else if (document.getElementById('domain').checked) {
        domainInput.style.display = 'block';
        defaultInput.style.display = 'none';
    }
}

function handleCheckboxChange(event) {
    var checkboxes = document.querySelectorAll('.feature input[type="checkbox"]');
    checkboxes.forEach(function(checkbox) {
        if (checkbox !== event.target) {
            checkbox.checked = false;
        }
    });
    updatePlaceholder();
}

function validateForm(event) {
    var checkboxes = document.querySelectorAll('.feature input[type="checkbox"]');
    var atLeastOneChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

    if (!atLeastOneChecked) {
        alert("Please select at least one feature.");
        event.preventDefault(); // Prevent form submission
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var checkboxes = document.querySelectorAll('.feature input[type="checkbox"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', handleCheckboxChange);
    });

    // Add form validation on submit
    var form = document.querySelector('form');
    form.addEventListener('submit', validateForm);

    // Update placeholders based on old input
    updatePlaceholder();
});
</script>

</head>
<body>
    <div class="display">
        <div class="container">
        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
        <h1>Geolocation and Security Tool</h1>
        <p style="color: #777; margin-bottom: 1rem;">
            A modern and innovative tool to check your files for malware threats.
        </p>
        <form id="malwareForm" action="{{ route('site.home') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <input type="text" id="defaultInput" name="defaultInput" placeholder="Please Choose One Option." readonly>
            <input type="text" id="geolocationInput" name="geolocationInput" placeholder="Enter IP Address for Geolocation" value="{{ old('geolocationInput') }}" style="{{ old('geolocationInput') ? 'display:block;' : 'display:none;' }}">
            <input type="text" id="nmapInput" name="nmapInput" placeholder="Enter IP Address for Nmap Scan" value="{{ old('nmapInput') }}" style="{{ old('nmapInput') ? 'display:block;' : 'display:none;' }}">
            <input type="text" id="gobusterInput" name="gobusterInput" placeholder="Enter Website URL for Gobuster" value="{{ old('gobusterInput') }}" style="{{ old('gobusterInput') ? 'display:block;' : 'display:none;' }}">
            <input type="text" id="gobustersubdomainInput" name="gobustersubdomainInput" placeholder="Enter Website URL for Gobuster Sub Domain" value="{{ old('gobustersubdomainInput') }}" style="{{ old('gobustersubdomainInput') ? 'display:block;' : 'display:none;' }}">
            <input type="text" id="dirbInput" name="dirbInput" placeholder="Enter Website URL for Dirb" value="{{ old('dirbInput') }}" style="{{ old('dirbInput') ? 'display:block;' : 'display:none;' }}">
            <input type="text" id="domainInput" name="domainInput" placeholder="Enter Domain for IP Lookup" value="{{ old('domainInput') }}" style="{{ old('domainInput') ? 'display:block;' : 'display:none;' }}">

            <div class="feature">
                <input type="checkbox" id="geolocation" name="geolocation" {{ old('geolocation') ? 'checked' : '' }}>
                <label for="geolocation">Geolocation IP Scan</label>
            </div>
            <div class="feature">
                <input type="checkbox" id="nmap" name="nmap" {{ old('nmap') ? 'checked' : '' }}>
                <label for="nmap">Nmap Port Scan</label>
            </div>
            <div class="feature">
                <input type="checkbox" id="gobuster" name="gobuster" {{ old('gobuster') ? 'checked' : '' }}>
                <label for="gobuster">Gobuster Directory Enumeration</label>
            </div>
            <div class="feature">
                <input type="checkbox" id="gobustersubdomain" name="gobustersubdomain" {{ old('gobustersubdomain') ? 'checked' : '' }}>
                <label for="gobustersubdomain">Gobuster Sub Domain Enumeration</label>
            </div>
            <div class="feature">
                <input type="checkbox" id="dirb" name="dirb" {{ old('dirb') ? 'checked' : '' }}>
                <label for="dirb">Dirb Website Enumeration</label>
            </div>
            <div class="feature">
                <input type="checkbox" id="domain" name="domain" {{ old('domain') ? 'checked' : '' }}>
                <label for="domain">Domain to IP Lookup</label>
            </div>
            <button type="submit">Get Results</button>
        </form>
        </div>

        <!-- Result Section -->
        @if(isset($results) || isset($error))
            <div class="result-container visible">
            @if(isset($results['geolocation']))
            <div class="result">
                <h2>Geolocation IP Scan Result</h2>
                <pre>{{ $results['geolocation'] }}</pre>
            </div>
        @endif

        @if(isset($results['nmap']))
            <div class="result">
                <h2>Nmap Port Scan Result</h2>
                <pre>{{ $results['nmap'] }}</pre>
            </div>
        @endif

        @if(isset($results['gobuster']))
            <div class="result">
                <h2>Gobuster Directory Enumeration Result</h2>
                <pre>{{ $results['gobuster'] }}</pre>
            </div>
        @endif

        @if(isset($results['gobustersubdomain']))
            <div class="result">
                <h2>Gobuster Sub Domain Enumeration Result</h2>
                <pre>{{ $results['gobustersubdomain'] }}</pre>
            </div>
        @endif

        @if(isset($results['dirb']))
            <div class="result">
                <h2>Dirb Website Enumeration Result</h2>
                <pre>{{ $results['dirb'] }}</pre>
            </div>
        @endif

        @if(isset($results['domain']))
            <div class="result">
                <h2>Domain to IP Lookup Result</h2>
                <pre>{{ $results['domain'] }}</pre>
            </div>
        @endif
            </div>
        @endif
    </div>
</body>
</html>
