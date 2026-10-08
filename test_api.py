import requests

BASE_URL = "http://ops.test/api"
# Ganti dengan token Sanctum asli lu dari tinker
BEARER_TOKEN = "1|sPtFXamYqvDInjb9jIdeZh5YqTYJffcz1y5sD8lXe1f8cd96"

headers = {
    "Authorization": f"Bearer {BEARER_TOKEN}",
    "Accept": "application/json",
    "Content-Type": "application/json"
}

def check_status():
    res = requests.get(f"{BASE_URL}/ops/status", headers=headers)
    print("=== TEST GET STATUS ===")
    print("HTTP Code:", res.status_code)
    print("Response:", res.json())

def execute_action(action_name):
    payload = {
        "action": action_name,
        "payload": {"target_server": "prod-01"}
    }
    res = requests.post(f"{BASE_URL}/ops/execute", json=payload, headers=headers)
    print("\n=== TEST POST EXECUTE ===")
    print("HTTP Code:", res.status_code)
    print("Response:", res.json())

if __name__ == "__main__":
    check_status()
    execute_action("restart_nginx")
