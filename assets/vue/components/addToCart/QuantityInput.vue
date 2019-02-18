<template lang="pug">
form.d-inline-block(@submit.prevent)
    .d-flex.form-group
        button(@click="lowerQuantity") -
        input(type="number", min="1", :value="quantity", name="quantity", id="quantity")
        button(@click="raiseQuantity") +
    input(:value="productId", hidden, name="productId", id="productId")
    
</template>

<script lang="ts">
export default {
    name: "QuantityInput",
    props: {
    	productId: {
    		type: String,
            default: undefined
        },
        quantity: {
    		type: Number,
            default: 1,
        },
    },
    methods: {
    	lowerQuantity() {
    		if (this.quantity > 1) {
    			this.quantity--;
                this.updateQuantity();
            }
		},
        raiseQuantity() {
			this.quantity++;
			this.updateQuantity();
        },
        updateQuantity() {
			const data = {
				'product_id': this.productId,
				'quantity': this.quantity,
			};

			this
				.$http
				.post('wp-admin/admin-ajax.php/?action=update_cart', data)
				.then(res => {
					console.info(res)
				})
				.catch(err => {
					console.error(err);
				})
        }
    }
};
</script>

<style scoped lang="sass">

</style>
