<template>
    <article v-if="loaded" class="kiyoh">
        <section class="topper">
            <aside class="score">
                <kiyoh-circle-component :grade="totalScore"></kiyoh-circle-component>
            </aside>
            <aside class="sidebar text-right">
                {{ totalReviews }} Beoordelingen
            </aside>
        </section>

        <section class="review">
            {{ latestReview }}
        </section>
        
        <a :href="siteUrl" class="kiyoh_button" target="_blank">Kiyoh</a>
    </article>
</template>

<script lang="ts">
import KiyohCircleComponent from '../../components/Kiyoh/KiyohCircleComponent';

export default {
  name: 'KiyohReviews',
  data() {
    return {
      loaded: false,
      totalScore: null,
      totalReviews: null,
      siteUrl: null,
      latestReview: null,
    }
  },
  components: {
  	KiyohCircleComponent
  },
  props: {
    fetchUrl: {
      type: String,
      default: 'wp-admin/admin-ajax.php?action=fetch_kiyoh'
    }
  },
  mounted() {
    this.$http
      .get(this.fetchUrl)
      .then((res) => {
        if (res.data.data) {
          this.loaded = true;
          const data = res.data.data;
          this.totalScore = data.total_score;
          this.totalReviews = data.total_reviews;
          this.siteUrl = data.kiyoh_url;
          this.latestReview = data.reviews.pro;
        }
      })
  }
};
</script>

<style scoped lang="sass">
.kiyoh
    padding: 10px
    
.topper
    margin-bottom: 0.5rem

.review
    $color: rgba(#333, 0.5)
    position: relative
    display: block
    border: 1px solid $color
    border-radius: 12px
    padding: 10px
    color: $color
    margin-bottom: 0.5rem
    max-height: 5rem
    overflow: hidden

.kiyoh_button
    background: #333
    display: block
    text-align: center
    padding: 3px
    font-size: 1.5rem
    color: #fff
    
.topper
    display: grid
    grid-template-columns: 20% 80%
    grid-template-rows: 1fr
</style>
