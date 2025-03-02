const express = require('express');
const app = express();
const cors = require('cors');

app.use(cors({
    origin: 'http://127.0.0.1:3000',
}));
const port = 3000;

app.get('/', (req, res) => {
    res.send('Hello from Node.js server!');
});

app.listen(8000);