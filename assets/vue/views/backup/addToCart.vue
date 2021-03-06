<template>
    <form @submit.prevent="addToCart" class="overflow-hidden" :class="{ 'px-2' : isExpanded }">
        <input type="hidden" name="product_id" id="product_id" v-model="productId" v-if="isExpanded">
        <div class="form-group d-flex" v-if="isExpanded">
            <label for="quantity" class="sr-only">Hoeveelheid</label>
            <button type="button" class="button-minus" @click="lowerQuantity">-</button>
            <input type="number" min="1" name="quantity" id="quantity" v-model="quantity">
            <button type="button" class="button-plus" @click="quantity++">+</button>
        </div>
        
        <div class="form-group" v-if="isExpanded" :disabled="!inStock && !canBackorder">
            <button class="submit-button expanded-submit-button" type="submit">Bestellen</button>
        </div>
        
        <button type="submit" class="submit-button" :disabled="!inStock && !canBackorder" v-if="!isExpanded">
            <i class="fas fa-shopping-cart"></i>
        </button>
    
        <section>
            <notifications-component
                    v-if="!inStock && !canBackorder"
                    :is-expanded="isExpanded"
                    content="Tijdelijk uitverkocht."
            ></notifications-component>
            <notifications-component
                    v-if="!inStock && canBackorder"
                    :is-expanded="isExpanded"
                    content="Tijdelijk uitverkocht."
            ></notifications-component>
            <notifications-component
                    v-if="isSuccess"
                    :is-expanded="isExpanded"
                    content="Toegevoegd aan winkelmandje!"
            ></notifications-component>
            <notifications-component
                    v-if="isFailed"
                    :is-expanded="isExpanded"
                    content="Het is niet gelukt om dit product toe te voegen. Probeer het nogmaals."
            ></notifications-component>
        </section>
    </form>
</template>

<script>
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
			addToCart() {
				this.$el.querySelector('.submit-button').disabled = true;
                const data = {
                    'product_id': this.productId,
                    'quantity': this.quantity,
                };
                
                this.$http
                    .post('wp-admin/admin-ajax.php/?action=add_to_cart', data)
                    .then(res => {
						this.$el.querySelector('.submit-button').disabled = false;
						this.isSuccess = true;
						this.productName = res.data.data.product;
                        const self = this;
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
            }
        },
      beforeMount() {
		  this.$http
            .get(`wp-admin/admin-ajax.php?action=check_stock&product_id=${this.productId}`)
            .then(res => {
              if(res.data.data.hasOwnProperty('backorder')) {
                this.inStock = false;
                if(res.data.data.backorder === 1) {
                  this.canBackorder = true;
                }
              }
            })
            .catch(err => console.warn(err));
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
    padding: 5px 10px
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
    padding: 10px 20px

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

.button-minus
    border-top-right-radius: 0
    border-bottom-right-radius: 0
    
.button-plus
    border-top-left-radius: 0
    border-bottom-left-radius: 0
.overflow-hidden
    overflow: hidden
</style>
