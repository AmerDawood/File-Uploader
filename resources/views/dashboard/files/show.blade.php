<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">


    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

html {
  box-sizing: border-box;
}

*,
*:before,
*:after {
  box-sizing: border-box;
}

body {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  background-color: #f9fafb;
  font-size: 70%;
  line-height: 1.4;
  font-family: "Inter", sans-serif;
  color: #6b7280;
  font-weight: 400;

  @media only screen and (min-width: 600px) {
    justify-content: center;
    align-items: center;
    display: flex;
    height: 100vh;
    font-size: 100%;
  }
}

// -------------- BUTTON

.button {
  appearance: none;
  background: #16a34a;
  border-radius: 0.25em;
  color: white;
  cursor: pointer;
  display: inline-block;
  font-weight: 500;
  height: 3em;
  line-height: 3em;
  padding: 0 1em;

  &:hover {
    background-color: lighten(#16a34a, 2%);
  }
}

// -------------- DETAILS MODAL

.details-modal {
  background: #ffffff;
  border-radius: 0.5em;
  box-shadow: 0 10px 20px rgba(black, 0.2);
  left: 50%;
  max-width: 90%;
  pointer-events: all;
  position: absolute;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 30em;
  text-align: left;
  max-height: 90vh;
  display: flex;
  flex-direction: column;

  // -------------- CLOSE

  .details-modal-close {
    align-items: center;
    color: #111827;
    display: flex;
    height: 4.5em;
    justify-content: center;
    pointer-events: none;
    position: absolute;
    right: 0;
    top: 0;
    width: 4.5em;

    svg {
      display: block;
    }
  }

  // -------------- TITLE

  .details-modal-title {
    color: #111827;
    padding: 1.5em 2em;
    pointer-events: all;
    position: relative;
    width: calc(100% - 4.5em);

    h1 {
      font-size: 1.25rem;
      font-weight: 600;
      line-height: normal;
    }
  }

  // -------------- CONTENT

  .details-modal-content {
    border-top: 1px solid #e0e0e0;
    padding: 2em;
    pointer-events: all;
    overflow: auto;
  }
}

// -------------- OVERLAY

.details-modal-overlay {
  transition: opacity 0.2s ease-out;
  pointer-events: none;
  background: rgba(#0f172a, 0.8);
  position: fixed;
  opacity: 0;
  bottom: 0;
  right: 0;
  left: 0;
  top: 0;

  details[open] & {
    pointer-events: all;
    opacity: 0.5;
  }
}

// -------------- DETAILS

details {
  summary {
    list-style: none;

    &:focus {
      outline: none;
    }
    &::-webkit-details-marker {
      display: none;
    }
  }
}

// -------------- OTHER

code {
  font-family: Monaco, monospace;
  line-height: 100%;
  background-color: #2d2d2c;
  padding: 0.1em 0.4em;
  letter-spacing: -0.05em;
  word-break: normal;
  border-radius: 7px;
  color: white;
  font-weight: normal;
  font-size: 1.75rem;
  position: relative;
  top: -2px;
}

.container {
  text-align: center;
  max-width: 40em;
  padding: 2em;

  > h1 {
    font-weight: 700;
    font-size: 2rem;
    line-height: normal;
    color: #111827;
  }

  > p {
    margin-top: 2em;
    margin-bottom: 2em;
  }

  sup {
    font-size: 1rem;
    margin-left: 0.25em;
    opacity: 0.5;
    position: relative;
  }
}

    </style>
</head>
<body>
    <div class="container">

        <h1>
          Making the <code>&lt;details&gt;</code> element look and behave like a modal<sup>(kinda..)</sup>
        </h1>

        <h4>{{ $file->filename }}</h4>

           <!-- Your existing button -->
           <button type="button" class="btn btn-success" id="downloadBtn" data-secret-key="{{ $file->secret_key }}">Download Now</button>

<!-- Modal dialog for entering the secret key -->
<div id="secretKeyModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enter Secret Key</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Secret Key</span>
                    <input type="text" class="form-control" id="secretKeyInput" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="installBtn">Install</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


      </div>



      <script>
   // Get the button and modal elements
const downloadBtn = document.getElementById('downloadBtn');
const secretKeyModal = document.getElementById('secretKeyModal');
const secretKeyInput = document.getElementById('secretKeyInput');
const installBtn = document.getElementById('installBtn');

// Add event listener to the Download Now button
downloadBtn.addEventListener('click', () => {
    // Show the modal dialog
    secretKeyModal.style.display = 'block';
});

// Add event listener to the Install button inside the modal
installBtn.addEventListener('click', () => {
    // Get the entered secret key
    const enteredSecretKey = secretKeyInput.value;

    // Get the secret key of the file from the button's data-secret-key attribute
    const fileSecretKey = downloadBtn.getAttribute('data-secret-key');

    // Check if the entered secret key matches the secret key of the file
    if (enteredSecretKey === fileSecretKey) {
      // Make an AJAX request to the server to initiate the file download
      fetch('/download-file', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                secretKey: enteredSecretKey,
                file: {
                    filename: '{{ $file->filename }}',
                    path: '{{ $file->path }}',
                },
            }),
        })
        .then(response => response.blob())
        .then(blob => {
            // Create a temporary anchor element to trigger the file download
            const downloadLink = document.createElement('a');
            downloadLink.href = URL.createObjectURL(blob);
            downloadLink.download = '{{ $file->filename }}'; // Replace with the desired file name
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);

            // Hide the modal dialog after successful installation
            secretKeyModal.style.display = 'none';
            alert('Installation started!');
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    } else {
        // Show an error message if the secret key is incorrect
        alert('Incorrect Secret Key. Installation failed.');
    }
});

// Add event listener to hide the modal when the user clicks the close button
secretKeyModal.querySelector('.close').addEventListener('click', () => {
    secretKeyModal.style.display = 'none';
});


      </script>
</body>
</html>
