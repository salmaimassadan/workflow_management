<!DOCTYPE html>
<html>
<head>
    <title>OCR for Laravel</title>
    <meta name="_token" content="{{ csrf_token() }}" />
</head>
<body>
    <h3>OCR for Laravel</h3>
    <input type="file" id="imageInput">
    <button onclick="uploadAndProcessOCR()">Upload and Process OCR</button>
    
    <script>
        async function uploadAndProcessOCR() {
            const imageInput = document.getElementById('imageInput');
            const formData = new FormData();
            formData.append('image', imageInput.files[0]);
            formData.append('_token', document.querySelector("meta[name='_token']").getAttribute("content"));
            
            const response = await fetch('{{ route('ocr.process') }}', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            console.log(result);
            alert('OCR processing completed. Check console for details.');
        }
    </script>
</body>
</html>
