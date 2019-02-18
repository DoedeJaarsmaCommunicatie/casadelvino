<template lang="pug">
form
    button -
    input(type="num", min="1", :value="quantity")
    button +
    input(:value="productId")
    
</template>

<script lang="ts">
export default {
    name: "QuantityInput",
    props: {
    	productID: {
    		type: Number,
            default: undefined
        },
        quantity: {
    		type: Number,
            default: 1,
        },
    }
};
</script>

<style scoped lang="sass">

</style>
