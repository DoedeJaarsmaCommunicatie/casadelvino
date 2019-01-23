<template>
    <form @submit.prevent>
        <input type="hidden" name="product_id" id="product_id" v-model="productId">
        <div class="form-group" v-if="isExpanded">
            <label for="quantity" class="sr-only">Hoeveelheid</label>
            <input type="number" name="quantity" id="quantity" v-model="quantity">
        </div>
        <button type="submit" class="submit-button">
            <i class="fas fa-shopping-cart"></i>
        </button>
    </form>
</template>

<script>
	export default {
		name: "addToCart",
        data() {
			return {
				quantity: 1
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
    color: var(--dark)
    -webkit-transition: all 0.3s
    -moz-transition: all 0.3s
    -ms-transition: all 0.3s
    -o-transition: all 0.3s
    transition: all 0.3s
    &:hover
        background: var(--primary-opaque-20)
</style>