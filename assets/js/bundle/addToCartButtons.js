import React, { render, h } from 'preact';
import { AddToCartForm as Form } from '@elderbraum/wine-components';
import { ThemeProvider, withTheme } from 'styled-components'

const StyledForm = withTheme(Form)

export function renderAddToCartButtons() {
  const targets = document.querySelectorAll('.pr-add-to-cart');

  for ( let i = 0; i < targets.length; i++ ) {
    const target = targets[i];
    const {
      product,
      qty,
      label,
      outline
    } = target.dataset;

    render(<ThemeProvider theme={{
      outlined: !!outline,
      background: '#69796b',
      color: '#fff',
      borderColor: '#69796b'
    }}>
      <StyledForm product={product}
                  label={label}
                  amount={qty} />
    </ThemeProvider>, target);
  }
}

renderAddToCartButtons()
