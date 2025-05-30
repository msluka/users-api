
### Dokumentacja REST API - Użytkownicy (/api/users)

API nie wymaga rejestracji ani autoryzacji. 
Wszystkie zasoby są dostępne publicznie — każdy użytkownik może tworzyć, edytować, aktualizować i usuwać dane.

### GET /api/users
Zwraca listę wszystkich użytkowników wraz z ich adresami e-mail.
- Przykładowa odpowiedź:
```json
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
```

### POST /api/users
Tworzy nowego użytkownika z wieloma adresami e-mail.
- Przykładowe dane wejściowe:
```json
{
  "firstname": "John",
  "lastname": "Doe",
  "phone_number": "123456789",
  "emails": [
    "john@example.com",
    "john.doe@example.com"
  ]
}
```
**Walidacja:**
- firstname, lastname, phone_number – wymagane, tekstowe
- emails – tablica e-maili (wymagany)
- Odpowiedź: 201 Created
```json
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
```
### GET /api/users/{id}
Zwraca szczegóły jednego użytkownika wraz z adresami e-mail.
- Przykładowa odpowiedź:
```json
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
```
### PUT /api/users/{id}
Aktualizuje dane użytkownika i jego adresy e-mail.
- Body (JSON, przykładowo):
```json
{
  "firstname": "Jan",
  "emails": [
    "jan.nowy@example.com"
  ]
}
```
**Uwagi:**
Wszystkie pola są opcjonalne, ale jeśli podane – muszą spełniać walidację.
Jeśli podano emails, poprzednie adresy e-mail są usuwane i zastępowane nowymi.

- Odpowiedź:
```json
{
  "id": 2,
  "firstname": "Jan",
  "lastname": "Doe",
  "phone_number": "123456789",
  "emails": [
    {"email": "jan.nowy@example.com"}
  ]
}
```
### DELETE /api/users/{id}
Usuwa użytkownika o podanym ID.
- Odpowiedź: 200 OK
```json
{
  "message": "User with ID 2 successfully deleted."
}
```
- Błąd: 404 Not Found
```json
{
  "message": "User with ID 999 not found."
}
```
### POST /api/users/{id}/welcome
Wysyła wiadomość powitalną do wszystkich adresów e-mail użytkownika.
- Odpowiedź:
```json
{
  "message": "Welcome email sent to all user emails."
}
```
#### Uwagi techniczne
- Wszystkie odpowiedzi korzystają z klasy UserResource, która formatuje dane użytkownika i jego relację emails.

- Walidacja odbywa się na poziomie kontrolera.

- Akcja sendWelcomeMessage używa serwisu WelcomeEmailService do wysyłki wiadomości powitalnej.
