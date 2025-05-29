**REST API Dokumentacja – Użytkownicy (/api/users)**
API nie wymaga rejestracji ani autoryzacji. 
Wszystkie zasoby są dostępne publicznie — każdy użytkownik może tworzyć, edytować, aktualizować i usuwać dane.

1. GET /api/users
**Zwraca listę wszystkich użytkowników wraz z ich adresami e-mail**.
**Przykładowa odpowiedź:**
[
  {
    "id": 1,
    "firstname": "John",
    "lastname": "Doe",
    "phone_number": "123456789",
    "emails": [
      {"email": "john@example.com"},
      {"email": "john.doe@example.com"}
    ]
  }
]

2. POST /api/users
**Tworzy nowego użytkownika z wieloma adresami e-mail.**
**Przykładowe dane wejściowe:**
{
  "firstname": "John",
  "lastname": "Doe",
  "phone_number": "123456789",
  "emails": [
    "john@example.com",
    "john.doe@example.com"
  ]
}

Walidacja:
firstname, lastname, phone_number – wymagane, tekstowe
emails – tablica e-maili (wymagany)
Odpowiedź: 201 Created
{
  "id": 2,
  "firstname": "John",
  "lastname": "Doe",
  "phone_number": "123456789",
  "emails": [
    {"email": "john@example.com"},
    {"email": "john.doe@example.com"}
  ]
}

3. GET /api/users/{id}
**Zwraca szczegóły jednego użytkownika wraz z adresami e-mail.**

Odpowiedź:
{
  "id": 2,
  "firstname": "John",
  "lastname": "Doe",
  "phone_number": "123456789",
  "emails": [
    {"email": "john@example.com"},
    {"email": "john.doe@example.com"}
  ]
}

4. PUT /api/users/{id}
**Aktualizuje dane użytkownika i jego adresy e-mail.**

Body (JSON, przykładowo):
{
  "firstname": "Jan",
  "emails": [
    "jan.nowy@example.com"
  ]
}

Uwagi:
Wszystkie pola są opcjonalne, ale jeśli podane – muszą spełniać walidację.
Jeśli podano emails, poprzednie adresy e-mail są usuwane i zastępowane nowymi.

Odpowiedź:
{
  "id": 2,
  "firstname": "Jan",
  "lastname": "Doe",
  "phone_number": "123456789",
  "emails": [
    {"email": "jan.nowy@example.com"}
  ]
}

5. DELETE /api/users/{id}
**Usuwa użytkownika o podanym ID.**

Odpowiedź: 200 OK
{
  "message": "User with ID 2 successfully deleted."
}

Błąd: 404 Not Found
{
  "message": "User with ID 999 not found."
}

6. POST /api/users/{id}/welcome
**Wysyła wiadomość powitalną do wszystkich adresów e-mail użytkownika.**

Odpowiedź:
{
  "message": "Welcome email sent to all user emails."
}

**Uwagi techniczne**
Wszystkie odpowiedzi korzystają z klasy UserResource, która formatuje dane użytkownika i jego relację emails.

Walidacja odbywa się na poziomie kontrolera.

Akcja sendWelcomeMessage używa serwisu WelcomeEmailService do wysyłki wiadomości powitalnej.
