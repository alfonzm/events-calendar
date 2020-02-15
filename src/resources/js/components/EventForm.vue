<template lang="pug">
    form(@submit='submitForm')
        div
            label.leading-relaxed Event
                input.appearance-none.w-full.font-size-base.leading-tight.px-3.py-2.border.border-gray-400.rounded(class='focus:outline-none focus:shadow' type='text' v-model='title' placeholder='My Event')
        .mt-5
                .flex.-mx-2
                    div(class='w-1/2 px-2')
                        label.leading-relaxed From
                        v-date-picker(v-model='start_date' :popover='popover' :input-props='{placeholder: "MM/DD/YYYY"}')
                    div(class='w-1/2 px-2')
                        label.leading-relaxed To
                        v-date-picker(v-model='end_date' :popover='popover' :input-props='{placeholder: "MM/DD/YYYY"}')
        .mt-5
            label.mr-2(v-for='(dayOfWeek, index) in daysOfWeek' :key='index')
                input(type='checkbox' :value='index' name='days' v-model='days')
                span.ml-1 {{ dayOfWeek }}
        .mt-5
            button(:class='[{spinner: isLoading}, "bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none"]' type='submit') Save
</template>

<script>

import moment from 'moment'

export default {
    props: [
        'isLoading',
        'event'
    ],
    data() {
        return {
            title: null,
            start_date: null,
            end_date: null,
            days: [],

            daysOfWeek: moment.weekdaysShort(),
            popover: {
                visibility: 'focus'
            }
        }
    },
    methods: {
        submitForm(e) {
            e.preventDefault()
            const dateFormat = 'YYYY-MM-DD'

            const startDate = this.start_date ? moment(this.start_date).format(dateFormat) : null
            const endDate = this.end_date ? moment(this.end_date).format(dateFormat) : null

            this.$emit('submit', {
                title: this.title,
                days: [...this.days],
                start_date: startDate,
                end_date: endDate
            })
        },
    }
}
</script>

<style>

</style>
