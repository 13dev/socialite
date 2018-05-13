<template>
	<section>
        <h3 class="subtitle">With Material Design Icons</h3>
        <b-field>
            <b-input placeholder="Search..."
                type="search"
                icon="magnify">
            </b-input>
        </b-field>

        <b-field>
            <b-input placeholder="Email"
                type="email"
                icon="email">
            </b-input>
        </b-field>

        <b-field>
            <b-input placeholder="Credit card"
                icon="credit-card">
            </b-input>
        </b-field>
    </section>
</template>

<script>
export default {

  name: 'Login',

  data () {
    return {

    }
  }
}
</script>

<style lang="css" scoped>

</style>