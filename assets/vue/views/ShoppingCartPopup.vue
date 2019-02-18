<template lang="pug">
section {{ cartItems }}
</template>

<script lang="ts">
export default {
    name: "ShoppingCartPopup",
    data() {
    	return {
    		cartItems: []
        }
    },
    beforeMount(): void {
    	this
            .$http
            .get('wp-admin/admin-ajax.php?action=get_cart_contents')
            .then( res => {
            	this.cartItems = res.data.data
            })
            .catch(err => {
            	console.warn(err)
            })
	}
};
</script>

<style scoped>

</style>
