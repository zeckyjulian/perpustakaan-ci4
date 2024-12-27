<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
  
    <div class="container col-lg-4 py-5">
      <div class="card bg-white shadow rounded-3 p-3 border-0">
        <video id="qr-video"></video>
        <p>
          <b>Detected QR code: </b>
          <span id="cam-qr-result">None</span>
        </p>

        <div>
          <b>Preferred camera:</b>
          <select id="cam-list">
          <option value="environment" selected>Environment Facing (default)</option>
          <option value="user">User Facing</option>
          </select>
        </div>

        <br>
        <button id="start-button" class="btn btn-success mt-3">Start</button>
        <button id="stop-button" class="btn btn-danger mt-2">Stop</button>
      </div>
    </div>
    
    <script type="module">
      import QrScanner from "/Assets/js/qr-scanner.min.js";

      // To enforce the use of the new api with detailed scan results, call the constructor with an options object, see below.
      const video = document.getElementById('qr-video');
      const videoContainer = document.getElementById('video-container');
      const camHasCamera = document.getElementById('cam-has-camera');
      const camList = document.getElementById('cam-list');
      const camQrResult = document.getElementById('cam-qr-result');

      function setResult(label, result) {
        console.log(result.data);
        window.open(result.data, '_blank');
        label.textContent = result.data;
        camQrResultTimestamp.textContent = new Date().toString();
        label.style.color = 'teal';
        clearTimeout(label.highlightTimeout);
        label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
      }

      // ####### Web Cam Scanning #######

      const scanner = new QrScanner(video, result => setResult(camQrResult, result), {
        onDecodeError: error => {
          camQrResult.textContent = error;
          camQrResult.style.color = 'inherit';
        },
        highlightScanRegion: true,
        highlightCodeOutline: true,
      });

      

      scanner.start().then(() => {
        // List cameras after the scanner started to avoid listCamera's stream and the scanner's stream being requested
        // at the same time which can result in listCamera's unconstrained stream also being offered to the scanner.
        // Note that we can also start the scanner after listCameras, we just have it this way around in the demo to
        // start the scanner earlier.
        QrScanner.listCameras(true).then(cameras => cameras.forEach(camera => {
              const option = document.createElement('option');
              option.value = camera.id;
              option.text = camera.label;
              camList.add(option);
          }));
      });

      QrScanner.hasCamera().then(hasCamera => camHasCamera.textContent = hasCamera);

      // for debugging
      window.scanner = scanner;

      camList.addEventListener('change', event => {
          scanner.setCamera(event.target.value).then(updateFlashAvailability);
      });

      document.getElementById('start-button').addEventListener('click', () => {
        scanner.start();
      });

      document.getElementById('stop-button').addEventListener('click', () => {
        scanner.stop();
      });

      // ####### File Scanning #######

      // fileSelector.addEventListener('change', event => {
      //   const file = fileSelector.files[0];
      //   if (!file) {
      //     return;
      //   }
      //   QrScanner.scanImage(file, { returnDetailedScanResult: true })
      //     .then(result => setResult(fileQrResult, result))
      //     .catch(e => setResult(fileQrResult, { data: e || 'No QR code found.' }));
      // });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>