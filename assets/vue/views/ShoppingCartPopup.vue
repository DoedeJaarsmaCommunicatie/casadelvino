<template lang="pug">
.position-fixed
    section.bg-white.shopping_cart_popup.p-md-4.position-relative
        i.fas.fa-times.fa-2x.closing_button.text-prim
        header
            span.h3.mr-2.text-prim Winkelwagentje
            span.text-muted.text-prim ({{ count }}) artikelen
        main(v-for="item in cart", :key="item.key")
            cart-item-component(:item="item")
        footer
            div.border-bottom.pl-2.d-flex.justify-content-between
                span.text-prim Voor 15:00 besteld, vandaag verzonden
                span.pr-4.text-dark
                    span.mr-2 totaal
                    span &euro; {{ total }}
            div.d-flex.mt-2.mr-4
                a.btn.bg-primary-dark-30.text-white.ml-auto(href="/betalen") afrekenen
</template>

<script lang="ts">
// @ts-ignore
import CartItemComponent from "../components/addToCart/CartItemComponent.vue";
export default {
    name: "ShoppingCartPopup",
	components: { CartItemComponent },
	data() {
    	return {
    		cart: [],
            totalPrice: 0,
        }
    },
    computed: {
        count() {
            return this.$_.size(this.cart)
        },
        total() {
        	let self = this;
            this.$_.each(this.cart, function (item) {
            	self.totalPrice += <number>item.price * <number>item.quantity;
            });
            return this.totalPrice.toFixed(2)
        }
    },
    beforeMount(): void {
    	this
            .$http
            .get('wp-admin/admin-ajax.php?action=get_cart_contents')
            .then( res => {
                this.cart = res.data.data
            })
            .catch(err => {
            	console.warn(err)
            })
	}
};
</script>

<style scoped lang="sass">
$prim: #69796B
$sec: #E5EAE6

.text-prim
    color: $prim !important
.text-sec
    color: $sec !important
.bg-prim
    background: $prim !important
.bg-sec
    background: $sec !important

.position-fixed
    top: 50%
    left: 50%
    -webkit-transform: translateX(-50%) translateY(-50%)
    -moz-transform: translateX(-50%) translateY(-50%)
    -ms-transform: translateX(-50%) translateY(-50%)
    -o-transform: translateX(-50%) translateY(-50%)
    transform: translateX(-50%) translateY(-50%)
    z-index: 999
    
.closing_button
    position: absolute
    right: 2rem
    top: 1rem

.shopping_cart_popup
    width: 50vw
    -webkit-box-shadow: 0 3px 8px rgba(#333, 0.4)
    -moz-box-shadow: 0 3px 8px rgba(#333, 0.4)
    box-shadow: 0 3px 8px rgba(#333, 0.4)
    @media screen and (max-width: 768px)
        width: 100vw
        height: 100vh
</style>
