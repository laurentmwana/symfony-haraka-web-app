export const Paypal = () => {
  window.paypal
    .Buttons({
      style: {
        layout: "horizontal",
      },
      message: {
        amount: 100,
      },

      async createOrder() {},

      async onApprove(data, actions) {},
    })
    .render("#paypal-button-container");
};
