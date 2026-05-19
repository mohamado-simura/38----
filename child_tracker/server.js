const express = require('express');
const cors = require('cors');

const app = express();
app.use(express.json());
app.use(cors());

let latestLocation = { lat: 23.8103, lng: 90.4125 };

app.post('/sos', (req, res) => {
  const { lat, lng } = req.body;
  latestLocation = { lat, lng };
  console.log('SOS received:', latestLocation);
  res.json({ ok: true });
});

app.get('/location', (req, res) => {
  res.json(latestLocation);
});

app.listen(3000, () => {
  console.log('Server running on http://localhost:3000');
});const express = require('express');
const cors = require('cors');

const app = express();
app.use(express.json());
app.use(cors());

let latestLocation = { lat: 23.8103, lng: 90.4125 };

app.post('/sos', (req, res) => {
  const { lat, lng } = req.body;
  latestLocation = { lat, lng };
  console.log('SOS received:', latestLocation);
  res.json({ ok: true });
});

app.get('/location', (req, res) => {
  res.json(latestLocation);
});

app.listen(3000, () => {
  console.log('Server running on http://localhost:3000');
});