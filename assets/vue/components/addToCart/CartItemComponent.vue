<template lang="pug">
.bg-sec.p-1.px-2.my-1.round-my-corners.d-flex.align-items-center
    span.mr-auto {{ item.name }}
    span.font-weight-bold &euro; {{ item.price }}
    quantity-input(:product-id="item.cart_key", :initial-quantity="parseInt(item.quantity)", @quantity-update="quantityUpdate", @updating="updateStarting")
    transition(name="fade", mode="out-in")
        span.font-weight-bold.mx-1
            span(v-show="!isLoading") &euro; {{ total }}
            span(v-show="isLoading") updaten...
    .d-inline-flex.form-group.m-0
        button.remove-button.round-my-corners(@click="deleteProduct"): i.fas.fa-times
</template>

<script lang="ts">
// @ts-ignore
import QuantityInput from "./QuantityInput.vue";
export default {
    name: "CartItemComponent",
	components: { QuantityInput },
    data() {
    	return {
    		isLoading: false
        }
    },
	props: {
    	item: {
    		type: Object,
            default: undefined
        }
    },
    computed: {
    	total() {
    		return (<number>this.item.quantity) * (<number>this.item.price)
        }
    },
    methods: {
    	quantityUpdate({msg, product, quantity}) {
    		this.isLoading = false;
    		if(msg === 'updated') {
    			this.item.quantity = quantity
            }
    		
    		this.$emit('update-finished')
        },
        updateStarting() {
    		this.isLoading = true;
    		this.$emit('updating')
        },
		deleteProduct() {
			this.quantity = 0;
			const data = {
				'product_id': this.item.cart_key,
				'quantity': 0,
			};

			this.$store.dispatch('update_cart', data)
				.then(() => {
					this.$emit('update-finished');
				});
		}
    }
};
</script>

<style scoped lang="sass">
.round-my-corners
    -webkit-border-radius: 5px
    -moz-border-radius: 5px
    border-radius: 5px
    font-weight: lighter
    
.fade-enter-active, .fade-leave-active
    transition: opacity .5s
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
  opacity: 0
  
.remove-button
    background: none
    border: none
    &:hover
        background: rgba(51,51,51,0.2)
        cursor: pointer
    &:active
        background: rgba(51,51,51,0.3)
        cursor: pointer



</style>
