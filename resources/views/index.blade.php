<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SEO Rank Checker</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg">
    <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">SERP Rank Checker</h1>

    <form id="searchForm" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Keyword</label>
            <input type="text" id="keyword" required placeholder="e.g., albert einstein"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Target Domain</label>
            <input type="text" id="domain" required placeholder="e.g., en.wikipedia.org"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Location Code</label>
                <input type="number" id="location" value="2840" required
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <p class="text-xs text-gray-500 mt-1">2840 - USA</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Language Code</label>
                <input type="text" id="language" value="en" required
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <p class="text-xs text-gray-500 mt-1">en - English</p>
            </div>
        </div>

        <button type="submit" id="submitBtn"
                class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
            Search
        </button>
    </form>

    <div id="resultContainer" class="mt-6 hidden">
        <div class="p-4 rounded-md border" id="resultBox">
        </div>
    </div>
</div>

<script>
    document.getElementById('searchForm').addEventListener('submit', async function(event) {
        event.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        const resultContainer = document.getElementById('resultContainer');
        const resultBox = document.getElementById('resultBox');

        const payload = {
            keyword: document.getElementById('keyword').value,
            domain: document.getElementById('domain').value,
            location_code: document.getElementById('location').value,
            language_code: document.getElementById('language').value
        };

        submitBtn.disabled = true;
        submitBtn.innerText = 'Searching...';
        resultContainer.classList.add('hidden');

        try {
            const response = await fetch('/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            resultContainer.classList.remove('hidden');

            if (data.status === 'success') {
                resultBox.className = 'p-4 rounded-md border bg-green-50 border-green-200 text-green-800';
                resultBox.innerHTML = `<strong>Success!</strong> ${data.message}`;
            } else {
                resultBox.className = 'p-4 rounded-md border bg-red-50 border-red-200 text-red-800';
                resultBox.innerHTML = `<strong>Notice:</strong> ${data.message}`;
            }

        } catch (error) {
            console.error('Request failed:', error);
            resultContainer.classList.remove('hidden');
            resultBox.className = 'p-4 rounded-md border bg-red-50 border-red-200 text-red-800';
            resultBox.innerHTML = `<strong>Error:</strong> Failed to connect to the server.`;
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerText = 'Search';
        }
    });
</script>
</body>
</html>
