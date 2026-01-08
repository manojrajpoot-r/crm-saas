from flask import Flask, jsonify

app = Flask(__name__)

@app.route('/', methods=['GET'])
def home():
    return jsonify({
        "status": "ok",
        "message": "Flask server is running"
    })

@app.route('/test', methods=['GET'])
def test():
    return "TEST ROUTE WORKING"

if __name__ == "__main__":
    app.run(host="127.0.0.1", port=5000)
