<template lang="pug">
form.d-inline-block(@submit.prevent)
    .d-flex.form-group.m-0
        button.quantityButton(@click="lowerQuantity", :class="{ disabled: (quantity === 1)}") -
        input.quantityInput(type="number", min="1", v-model="quantity", name="quantity", id="quantity", @blur="updateQuantity")
        button.quantityButton(@click="raiseQuantity") +
    input(:value="productId", hidden, name="productId", id="productId")
</template>

<script lang="ts">
export default {
    name: "QuantityInput",
    data() {
    	return {
    		quantity: this.initialQuantity
        }
    },
    props: {
    	productId: {
    		type: String,
            default: undefined
        },
        initialQuantity: {
    		type: Number,
            default: 1,
        },
    },
    methods: {
    	lowerQuantity(): void {
    		if (this.quantity > 1) {
    			this.quantity--;
                this.updateQuantity();
            }
		},
        raiseQuantity(): void {
			this.quantity++;
			this.updateQuantity();
        },
        updateQuantity(): void {
			this.$emit('updating');

			const data = {
				'product_id': this.productId,
				'quantity': this.quantity,
			};
   
			this.$store.dispatch('update_cart', data)
                .then((res) => {
					this.$emit('quantity-update', {
						msg: res.data.data,
						product: data.product_id,
						quantity: data.quantity,
					});
                });
        },
    },
};
</script>

<style scoped lang="sass">
.quantityButton
    background: none
    border: none
    width: 40px
    -webkit-border-radius: 5px
    -moz-border-radius: 5px
    border-radius: 5px
    &:hover
        background: rgba(51,51,51,0.2)
        cursor: pointer
    &:active
        background: rgba(51,51,51,0.3)
        cursor: pointer
    &.disabled
        color: rgba(51,51,51,0.5)
        cursor: not-allowed
    
.quantityInput
    -webkit-appearance: textfield
    -moz-appearance: textfield
    appearance: textfield
    border: 1px solid #69796B
    -webkit-border-radius: 5px
    -moz-border-radius: 5px
    border-radius: 5px
    width: 45px
    text-align: center
</style>
