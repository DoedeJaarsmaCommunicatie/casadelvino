class WACfix {
  private buttons: NodeListOf<Element>;


  constructor() {
    this.findAllButtons();
    this.disableButtons();
  }

  findAllButtons(): void {
    this.buttons = document.querySelectorAll('.wac-qty-button');
  }

  disableButtons(): void {
    this.buttons.forEach(el => {
      el.querySelector('wac-btn-sub').addEventListener('click', () => {
        return false;
      });
    })
  }
}


document.addEventListener('DOMContentLoaded', () => {
  new WACfix();
});
