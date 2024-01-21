<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;
use YourNamespace\Model\User;
use YourNamespace\Utils\Mailer;

class UserController {

    public function getAllUsers(Request $request, Response $response, $args) {
        try {
            $users = User::all();
            $response->getBody()->write(json_encode($users));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['message' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function registerUser(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $email = $data['Email'];
        $pseudo = $data['Pseudo'];
        $password = password_hash($data['MotDePasse'], PASSWORD_DEFAULT);

        $userExists = User::where('Email', $email)->first();
        if ($userExists) {
            // Envoyer une réponse d'erreur
        }

        $newUser = new User();
        $newUser->setEmail($email);
        $newUser->setPseudo($pseudo);
        $newUser->setMotDePasse($password);
        $newUser->save();

        $token = JWT::encode(['id' => $newUser->getId()], $_ENV['JWT_SECRET']);

        // Envoyer une réponse avec le token JWT
    }

    public function loginUser(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $login = $data['login'];
        $password = $data['MotDePasse'];

        $user = User::where('Email', $login)->orWhere('Pseudo', $login)->first();
        if (!$user) {
            // Envoyer une réponse d'erreur
        }

        $passwordIsValid = password_verify($password, $user->getMotDePasse());
        if (!$passwordIsValid) {
            // Envoyer une réponse d'erreur
        }

        $token = JWT::encode(['id' => $user->getId()], $_ENV['JWT_SECRET']);

        // Envoyer une réponse avec le token JWT
    }

    public function getUserProfile(Request $request, Response $response, $args) {
        $userId = $request->getAttribute('userId'); // Assurez-vous que ce soit le même nom que celui dans votre middleware
        $user = User::find($userId);
        if (!$user) {
            // Envoyer une réponse d'erreur
        }

        // Envoyer le profil de l'utilisateur
    }

    public function updateUserProfile(Request $request, Response $response, $args) {
        $userId = $request->getAttribute('userId');
        $data = $request->getParsedBody();

        $user = User::find($userId);
        if (!$user) {
            // Envoyer une réponse d'erreur
        }

        $user->setPseudo($data['Pseudo'] ?? $user->getPseudo());
        $user->setEmail($data['Email'] ?? $user->getEmail());
        $user->save();

        // Envoyer une confirmation
    }

    public function requestPasswordReset(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $email = $data['Email'];

        $user = User::where('Email', $email)->first();
        if (!$user) {
            // Envoyer une réponse d'erreur
        }

        $resetToken = JWT::encode(['id' => $user->getId()], $_ENV['JWT_SECRET'], 'HS256', '1h');
        $user->setResetPasswordToken($resetToken);
        $user->setResetPasswordExpires(time() + 3600); // 1 heure
        $user->save();

        // Envoyer l'email avec Mailer

        // Envoyer une confirmation
    }

    public function resetPassword(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $token = $data['token'];
        $newPassword = $data['MotDePasse'];

        $user = User::where('ResetPasswordToken', $token)->where('ResetPasswordExpires', '>', time())->first();
        if (!$user) {
            // Envoyer une réponse d'erreur
        }

        $user->setMotDePasse(password_hash($newPassword, PASSWORD_DEFAULT));
        $user->setResetPasswordToken(null);
        $user->setResetPasswordExpires(null);
        $user->save();

        // Envoyer une confirmation
    }
}
