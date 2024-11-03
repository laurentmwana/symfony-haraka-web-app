import "./bootstrap";
import { Paypal } from "./js/components/paypal";

const onInit = () => {
  Paypal();
};

document.addEventListener("DOMContentLoaded", onInit);
