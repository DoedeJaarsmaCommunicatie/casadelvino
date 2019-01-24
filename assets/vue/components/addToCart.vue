<template>
    <form @submit.prevent="addToCart">
        <input type="hidden" name="product_id" id="product_id" v-model="productId" v-if="isExpanded">
        <div class="form-group" v-if="isExpanded">
            <label for="quantity" class="sr-only">Hoeveelheid</label>
            <input type="number" name="quantity" id="quantity" v-model="quantity">
        </div>
        
        <button type="submit" class="submit-button" >
            <i class="fas fa-shopping-cart"></i>
        </button>
        
        <transition name="fade">
            <section v-if="isSuccess" class="alert alert-success">
                {{ productName }} is {{ quantity }}x aan uw winkelwagen toegevoegd
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
                productName: null
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
        },
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
    
    
.fade-enter-active, .fade-leave-active
    transition: opacity .5s

.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
  opacity: 0
</style>