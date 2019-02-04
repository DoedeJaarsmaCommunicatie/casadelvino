<template>
    <aside class="notification-container" :class="{ 'notification-container-expanded': !isExpanded, 'notification-details': isExpanded}">
        <transition name="fade">
            <section class="alert" :class="{ className: className, 'alert-homepage': !isExpanded}">
                {{ content }}
            </section>
        </transition>
    </aside>
</template>

<script>
  export default {
    name: 'NotificationsComponent',
    props: {
      className: {
        type: String,
        default: null
      },
      isExpanded: false,
      content: null
    }
  };
</script>

<style scoped lang="sass">
.fade-enter-active, .fade-leave-active
    transition: opacity .5s
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
    opacity: 0
.notification-container
    background: var(--primary)
    color: var(--white)
.notification-container-expanded
    position: absolute
    width: 100%
    top: 50%
    left: 0
    transform: matrix(1,-0.2,0,1,0,0) translateY(-50%)
.notification-details
    @extend .notification-container-expanded
    text-align: center
    -webkit-transform: matrix(1, -0.2, 0, 1, 0, -100)
    -moz-transform: matrix(1, -0.2, 0, 1, 0, -100)
    -ms-transform: matrix(1, -0.2, 0, 1, 0, -100)
    -o-transform: matrix(1, -0.2, 0, 1, 0, -100)
    transform: matrix(1, -0.2, 0, 1, 0, -100)
    @media screen and (max-width: 768px)
        -webkit-transform: matrix(1, -0.2, 0, 1, 0, -40)
        -moz-transform: matrix(1, -0.2, 0, 1, 0, -40)
        -ms-transform: matrix(1, -0.2, 0, 1, 0, -40)
        -o-transform: matrix(1, -0.2, 0, 1, 0, -40)
        transform: matrix(1, -0.2, 0, 1, 0, -40)
</style>
