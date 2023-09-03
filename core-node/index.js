const http = require('http');
const url = require('url');
const StringDecoder = require('string_decoder').StringDecoder;
const getStudents = require('./student');
const getStaffs = require('./staff');

const port = 4000;

const routes = {
  student: getStudents,
  staff: getStaffs,
};

const notFound = (input, callback) => {
  callback(404);
};

const server = http.createServer((req, res) => {
  // Parse the request URL
  const parsedUrl = url.parse(req.url, true);

  // Get the path name excluding query string and hostname
  const path = parsedUrl.pathname;
  const parsedPath = path.replace(/^\/+/, '');

  // Get the HTTP method
  const method = req.method.toUpperCase();

  // Get query string/params as object
  const query = parsedUrl.query;

  // Get headers as object
  const headers = req.headers;

  const decoder = new StringDecoder('utf-8');
  let body = '';

  // Listen on data receive event
  req.on('data', (data) => {
    body += decoder.write(data);
  });

  // Listen on data end event
  req.on('end', () => {
    body += decoder.end();

    const routeHandler =
      typeof routes[parsedPath] !== 'undefined' ? routes[parsedPath] : notFound;

    const requestObject = {
      pathname: parsedPath,
      method,
      query,
      headers,
      body,
    };

    const callbackFunction = (statusCode, responseObject) => {
      statusCode = typeof statusCode === 'number' ? statusCode : 200;
      responseObject =
        typeof responseObject === 'object'
          ? responseObject
          : { message: '', data: null };

      res.setHeader('Access-Control-Allow-Origin', '*');
      // Set content type to response
      res.setHeader('Content-Type', 'application/json');
      // Set status code to response
      res.writeHead(statusCode);
      // Return response
      res.end(JSON.stringify(responseObject));
    };

    routeHandler(requestObject, callbackFunction);
  });
});

// Listen for requests
server.listen(port, () => {
  console.log(`Your app is running on port ${port}`);
});
