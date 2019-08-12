<template lang="pug">
.position-fixed(v-if='show')
    section.bg-white.shopping_cart_popup.p-md-4.position-relative.pt-5
        button.btn.closing_button(@click="close"): i.fas.fa-times.fa-2x.text-prim
        header
            span.h3.mr-2.ml-2.text-prim Winkelwagentje
            span.text-muted.text-prim ({{ count }}) artikelen
        .spinner-grow.text-primary(role="status", v-if="loading")
            span.sr-only loading...
        main(v-for="item in cart", :key="item.key")
            cart-item-component(:item="item", @update-finished="fetchData")
        footer
            div.border-bottom.pl-2.d-flex.justify-content-between
                span.text-prim Gratis verzenden in NL vanaf &euro; 50,- en BE vanaf &euro; 100,-
                span.pr-4.text-dark
                    span.mr-2 totaal
                    span &euro; {{ total }}
            div.d-flex.mt-2.mr-4
                a.btn.bg-primary-dark-30.text-white.ml-auto(href="/bestellen") afrekenen
</template>

<script lang="ts">
// @ts-ignore
import CartItemComponent from "../components/addToCart/CartItemComponent.vue";
export default {
    name: "ShoppingCartPopup",
	components: { CartItemComponent },
	data() {
    	return {
    		cart: this.$store.getters.cart,
            total: this.$store.getters.totalPrice,
            count: this.$store.getters.cartCount,
            show: true,
            loading: true,
        }
    },
    beforeMount(): void {
        this.fetchData();
	},
    methods: {
    	fetchData(): void {
			this.$store.dispatch('get_cart')
				.then(() => {
					this.loading = false;
					this.cart = this.$store.getters.cart;
					this.count = this.$store.getters.cartCount;
					this.total = this.$store.getters.totalPrice;
				})
				.catch((err) => {
					console.error(err)
				})
        },
        close(): void {
			this.$emit('close-shopping-cart');
			this.show = false
        }
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
    text-align: unset
    -webkit-box-shadow: 0 3px 8px rgba(51, 51, 51, 0.7)
    -moz-box-shadow: 0 3px 8px rgba(51, 51, 51, 0.7)
    box-shadow: 0 3px 8px rgba(51, 51, 51, 0.7)
    
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
        overflow-y: scroll

.spinner-grow
    display: inline-block
    width: 2rem
    height: 2rem
    vertical-align: text-bottom
    background-color: currentColor
    border-radius: 50%
    opacity: 0
    -webkit-animation: spinner-grow .75s linear infinite
    animation: spinner-grow .75s linear infinite
    
@-webkit-keyframes spinner-grow
    0%
        -webkit-transform: scale(0)
        transform: scale(0)
    50%
        opacity: 1

@keyframes spinner-grow
    0%
        -webkit-transform: scale(0)
        transform: scale(0)

    50%
        opacity: 1
</style>
