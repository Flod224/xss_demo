from http.server import BaseHTTPRequestHandler, HTTPServer

class MaliciousServer(BaseHTTPRequestHandler):
    def do_POST(self):
        content_length = int(self.headers['Content-Length'])  # Taille des données
        post_data = self.rfile.read(content_length)  # Lire les données envoyées
        print(f"Received data: {post_data.decode('utf-8')}")  # Afficher les données dans la console
        
        # Réponse au client
        self.send_response(200)
        self.end_headers()
        self.wfile.write(b"Data received!")

# Configuration du serveur
host = "127.0.0.1"
port = 8080
server = HTTPServer((host, port), MaliciousServer)
print(f"Server running on http://{host}:{port}")
server.serve_forever()
