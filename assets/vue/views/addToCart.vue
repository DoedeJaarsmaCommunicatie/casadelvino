<template lang="pug">
form.overflow-hidden(@submit.prevent="addToCartReload", :class="{ 'px-lg-2': isExpanded }", style="flex: 1 1 auto;")
    input(type="hidden", name="product_id", id="product_id", v-model="productId", v-if="isExpanded")
    .form-group.d-flex(v-if="isExpanded")
        label.sr-only(for="quantity") Hoeveelheid
        button.button-minus(type="button", @click="lowerQuantity") -
        input#quantity(type="number", min="1", v-model="quantity", name="quantity")
        button.button-plus(type="button", @click="quantity++") +
    .form-group.slotted-buttons(v-if="isExpanded", :disabled="!inStock && !canBackorder")
        button.submit-button.expanded-submit-button(type="submit")
            i.fas.fa-plus.mr-2
            | In wijnmandje
        slot

    button.submit-button(type="submit", :disabled="!inStock && !canBackorder", v-if="!isExpanded")
        i.fas.fa-cart-plus

    section
        cdv-mobile-cart(v-if="isSuccess", :product_name="productName", @close-shopping-cart="isSuccess = false")

    section
        notifications-component(v-if="!inStock && !canBackorder", :is-expanded="isExpanded", content="Tijdelijk uitverkocht.")
        notifications-component(v-if="!inStock && canBackorder", :is-expanded="isExpanded", content="Tijdelijk uitverkocht.")
        notifications-component(v-if="isFailed", :is-expanded="isExpanded", content="Het is niet gelukt om dit product toe te voegen. Probeer het nogmaals.")

</template>

<script lang="ts">
    // @ts-ignore
	import NotificationsComponent from '../components/addToCart/NotificationsComponent';

    export default {
        name: "addToCart",
        components: { NotificationsComponent },
        data() {
			return {
				quantity: 1,
                isLoading: false,
                isSuccess: false,
                isFailed: false,
                isReload: false,
                productName: null,
                inStock: true,
                canBackorder: false,
            }
        },
        props: {
			isExpanded: {
				type: Boolean,
                default: false,
            },
            productId: {
				type: Number,
                required: true,
            }
        },
        methods: {
            addToCartReload() {
              this.$el.querySelector('.submit-button').disabled = true;
              const data = {
                'product_id': this.productId,
                'quantity': this.quantity,
              };

              window.location.search = `?add-to-cart=${this.productId}&quantity=${this.quantity}`;
            },
			addToCart() {
				this.$el.querySelector('.submit-button').disabled = true;
                const data = {
                    'product_id': this.productId,
                    'quantity': this.quantity,
                };

                this
                    .$http
                    .post('wp-admin/admin-ajax.php/?action=add_to_cart', data)
                    .then(res => {
						this.$el.querySelector('.submit-button').disabled = false;
						if (res.data.success == false) {
							this.isFailed = true;
						} else {
							this.isSuccess = true;
                        }
						this.isSuccess = true;
						this.productName = res.data.data.product;
                    })
                    .catch(err => {
						this.$el.querySelector('.submit-button').disabled = false;
						console.error(err);
					})
            },
            lowerQuantity() {
				if(this.quantity > 1) {
					this.quantity--
                }
            },
            checkStock() {
				this.$http
					.get(`/wp-json/casa/v1/stock/${this.productId}`)
					.then(res => {
                      this.inStock = res.data[0];
                      this.canBackorder = true;
					})
					.catch();
            }
        },
      beforeMount() {
          this.checkStock();
      }
    };
</script>

<style scoped lang="sass">
.submit-button
    background: var(--primary)
    -webkit-border-radius: 5px
    -moz-border-radius: 5px
    border-radius: 5px
    border: 0
    padding: 10px 15px
    color: var(--white)
    -webkit-transition: all 0.3s
    -moz-transition: all 0.3s
    -ms-transition: all 0.3s
    -o-transition: all 0.3s
    transition: all 0.3s
    &:hover
        background: var(--primary-opaque-20)
        cursor: pointer
    &[disabled]
        background-color: var(--gray)


.expanded-submit-button
    @extend .submit-button
    background: #41A043
    width: 100%
    padding: 10px

#quantity
    -webkit-appearance: textfield
    -moz-appearance: textfield
    appearance: textfield
    border: 1px solid var(--primary-dark-40)
    border-left: 0
    border-right: 0
    margin: 0
    height: 45px
    text-align: center
    flex: 3 3 auto
    min-width: 50px

.button-minus, .button-plus
  @extend .submit-button
  background: var(--primary-dark-40)
  padding: 10px 20px
  flex: 1 1 auto
  touch-action: manipulation

.button-minus
    border-top-right-radius: 0
    border-bottom-right-radius: 0
.button-plus
    border-top-left-radius: 0
    border-bottom-left-radius: 0

.overflow-hidden
    overflow: hidden

.slotted-buttons
    display: flex
    .submit-button
        flex: 1 0 75%
    .simplefavorite-button
        margin-left: .5rem
        flex: 0 1 25%

.not-mobile
    @media screen and (max-width: 768px)
        display: none

.mobile-only
    @media screen and (min-width: 768px)
        display: none
</style>
