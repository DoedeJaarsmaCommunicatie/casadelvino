<template>
    <form @submit.prevent="addToCart" :class="{ 'px-2' : isExpanded }">
        <input type="hidden" name="product_id" id="product_id" v-model="productId" v-if="isExpanded">
        <div class="form-group d-flex" v-if="isExpanded">
            <label for="quantity" class="sr-only">Hoeveelheid</label>
            <button type="button" class="button-minus" @click="lowerQuantity">-</button>
            <input type="number" min="1" name="quantity" id="quantity" v-model="quantity">
            <button type="button" class="button-plus" @click="quantity++">+</button>
        </div>
        
        <div class="form-group" v-if="isExpanded" :disabled="!inStock && !canBackorder">
            <button class="expanded-submit-button" type="submit">Bestellen</button>
        </div>
        
        <button type="submit" class="submit-button" :disabled="!inStock && !canBackorder" v-if="!isExpanded">
            <i class="fas fa-shopping-cart"></i>
        </button>
        
        <section v-if="!inStock && !canBackorder" class="alert alert-warning" :class="{ 'alert-homepage': !isExpanded }">
            Dit product is uit ons assortiment. Neem contact met ons op om samen een alternatief te ontdekken.
        </section>
        
        <section v-if="!inStock && canBackorder" class="alert alert-warning" :class="{ 'alert-homepage': !isExpanded }">
            Dit product is tijdelijk uitverkocht. U kunt wel bestellen, dan komt de wijn z.s.m uw kant op.
        </section>
        
        
        <transition name="fade">
            <section v-if="isSuccess" class="alert alert-success" :class="{ 'alert-homepage': !isExpanded }">
                {{ productName }} is {{ quantity }}x aan uw winkelwagen toegevoegd
            </section>
            <section v-if="isFailed" class="alert alert-warning" :class="{ 'alert-homepage': !isExpanded }">
                Het is niet gelukt om {{ productName }} aan uw winkelwagen toe te voegen.
            </section>
        </transition>
    </form>
</template>

<script>
	export default {
		name: "addToCart",
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
						this.productName = res.data.data.product
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

.fade-enter-active, .fade-leave-active
    transition: opacity .5s

.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
    opacity: 0

.alert-homepage
    position: absolute
    top: 50%
    left: 0
    -webkit-transform: translateY(-50%)
    -moz-transform: translateY(-50%)
    -ms-transform: translateY(-50%)
    -o-transform: translateY(-50%)
    transform: translateY(-50%)
</style>