import http.server
import socketserver
import os
import urllib.parse
import mimetypes

DIRECTORY = os.path.dirname(os.path.abspath(__file__))

REDIRECTS = {
    "/home": "/",
    "/index": "/",
    "/about": "/about-us.html",
    "/contact": "/contact-us.html",
    "/careers": "/careers-at-diverse-pathwais.html",
    "/reviews": "/diverse-pathwais-reviews.html"
}

class CustomHandler(http.server.SimpleHTTPRequestHandler):
    def __init__(self, *args, **kwargs):
        super().__init__(*args, directory=DIRECTORY, **kwargs)

    def do_GET(self):
        parsed = urllib.parse.urlparse(self.path)
        url_path = parsed.path
        
        # Check redirects
        if url_path in REDIRECTS:
            self.send_response(301)
            self.send_header('Location', REDIRECTS[url_path])
            self.end_headers()
            return
            
        # Clean URL rewrite fallback (e.g. /about-us -> /about-us.html)
        if url_path != "/" and not os.path.splitext(url_path)[1]:
            candidate = os.path.join(DIRECTORY, url_path.lstrip('/') + '.html')
            if os.path.exists(candidate):
                self.path = url_path + '.html'
                if parsed.query:
                    self.path += '?' + parsed.query
        
        return super().do_GET()

if __name__ == '__main__':
    # Ensure correct mime types
    mimetypes.add_type('application/javascript', '.js')
    mimetypes.add_type('text/css', '.css')
    mimetypes.add_type('image/webp', '.webp')
    mimetypes.add_type('font/woff2', '.woff2')
    
    server_started = False
    for port in [8080, 8088, 5050, 3030]:
        try:
            socketserver.ThreadingTCPServer.allow_reuse_address = True
            httpd = socketserver.ThreadingTCPServer(("", port), CustomHandler)
            print(f"Serving visa website at http://localhost:{port}/", flush=True)
            server_started = True
            httpd.serve_forever()
            break
        except OSError:
            continue

    if not server_started:
        print("Could not bind to any test port.", flush=True)
