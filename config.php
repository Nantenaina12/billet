<?php
// config.php

// Identifiants PayPal Sandbox ou Live
define("PAYPAL_CLIENT_ID", "AZxd477LO0xCCuW-XHm0Zfe2T-gYm7gtBwlewpYtc_qXAhBkw8l4arpXmLBR9w0m3blzERw-u9YmzjPs"); 
// 👉 Remplace cette valeur par ton vrai Client ID complet

// URLs de redirection après paiement
define("RETURN_URL", "http://localhost/billetterie-can-maroc/pages/valider_paiement.php");
define("CANCEL_URL", "http://localhost/billetterie-can-maroc/pages/annuler.php");

// Autres configurations si nécessaire
// Par exemple, la devise utilisée
define("PAYPAL_CURRENCY", "USD");
