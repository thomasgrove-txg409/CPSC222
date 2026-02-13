from http.server import BaseHTTPRequestHandler, HTTPServer
import json
import pwd
import grp
from base64 import b64decode


class APIHandler(BaseHTTPRequestHandler):
    USERNAME = "test"
    PASSWORD = "abcABC123456"

    def do_GET(self):
        # Check authentication
        auth_header = self.headers.get("Authorization")
        if not auth_header or not auth_header.startswith("Basic "):
            self.send_response(401)
            self.send_header("WWW-Authenticate", 'Basic realm="Login required"')
            self.end_headers()
            return

        try:
            encoded = auth_header.split()[1]
            decoded = b64decode(encoded).decode()
            username, password = decoded.split(":")
        except Exception:
            self.send_response(401)
            self.end_headers()
            return

        if username != self.USERNAME or password != self.PASSWORD:
            self.send_response(403)
            self.end_headers()
            return

        # Determine which API path
        if self.path == "/api/users":
            data = {str(i): u.pw_name for i, u in enumerate(pwd.getpwall())}
        elif self.path == "/api/groups":
            data = {str(i): g.gr_name for i, g in enumerate(grp.getgrall())}
        else:
            self.send_response(404)
            self.end_headers()
            return

        # Send JSON response
        self.send_response(200)
        self.send_header("Content-Type", "application/json")
        self.end_headers()
        self.wfile.write(json.dumps(data).encode())


if __name__ == "__main__":
    server = HTTPServer(("", 3000), APIHandler)
    print("Server running on port 3000...")
    server.serve_forever()
