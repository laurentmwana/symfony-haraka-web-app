<?php

namespace App\Twig\Runtime;

use App\Payment\PaypalPayment;
use Twig\Extension\RuntimeExtensionInterface;

class PaypalCheckoutRuntime implements RuntimeExtensionInterface
{
    public function __construct(private PaypalPayment $paypalPayment) {}

    public function uiPaypal(): string
    {
        $clientId = $this->paypalPayment->clientId;

        return <<<HTML
        <div>
            <div id="paypal-button-container" class="w-full block"></div>
            <script
                src="https://www.paypal.com/sdk/js?client-id={$clientId}&buyer-country=US&currency=USD&components=buttons"
                data-sdk-integration-source="developer-studio"
            ></script>
        </div>
HTML;
    }
}
