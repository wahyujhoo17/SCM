const express = require('express');
const bodyParser = require('body-parser');
const { google } = require('googleapis');

const app = express();
const PORT = 3000;

app.use(bodyParser.raw({ type: 'application/pdf' }));

// Google Drive API credentials
const credentials = {
    "web": {
        "client_id": "544004194924-o99bav9uglklfjqm6uokdm5h7jpsvvlj.apps.googleusercontent.com",
        "project_id": "jaya-abadi-407006",
        "auth_uri": "https://accounts.google.com/o/oauth2/auth",
        "token_uri": "https://oauth2.googleapis.com/token",
        "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
        "client_secret": "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",
        "redirect_uris": ["https://developers.google.com/oauthplayground/"]
    }
};

const drive = google.drive({
    version: 'v3',
    auth: new google.auth.OAuth2(
        credentials.web.client_id,
        credentials.web.client_secret,
        credentials.web.redirect_uris[0]
    ),
});

app.post('/convert', (req, res) => {
    const fileMetadata = {
        name: 'converted-file.pdf',
        parents: ['your-folder-id-in-google-drive'],
    };

    const media = {
        mimeType: 'application/pdf',
        body: req.body,
    };

    drive.files.create({
        resource: fileMetadata,
        media: media,
        fields: 'id',
    }, (err, file) => {
        if (err) {
            console.error(err);
            res.status(500).send('Error uploading to Google Drive');
        } else {
            res.send('PDF converted and uploaded successfully. File ID: ' + file.data.id);
        }
    });
});

app.use(express.static('public'));

app.listen(PORT, () => {
    console.log(`Server is running at http://localhost:${PORT}`);
});
