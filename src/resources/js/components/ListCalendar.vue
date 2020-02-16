<template lang="pug">
    section
        .flex.items-center.justify-between.mb-3
            .text-4xl {{ calendarTitle }}
            div
                button.py-2.px-4.mr-1.rounded.bg-gray-300.text-gray-800(class='hover:bg-gray-400 focus:outline-none' @click='showPrevMonth' type='button') <
                button.py-2.px-4.rounded.bg-gray-300.text-gray-800(class='hover:bg-gray-400 focus:outline-none' @click='showNextMonth' type='button') >
        table.w-full
            tr.border-t(v-for='eventDay in eventDays' :class='{ "bg-green-100": eventDay.title }')
                td.p-3(class='w-1/3 md:w-1/6') {{ eventDay.dayLabel }}
                td.p-3(class='w-2/3 md:w-5/6') {{ eventDay.title }}
</template>

<script>
import moment from 'moment'

export default {
    props: ['events'],
    data() {
        return {
            currentMonth: null, // integer 0-11
            currentYear: null,
            currentMonthMomentDates: [],
        }
    },
    computed: {
        calendarTitle () {
            return this.currentYear != null && this.currentMonth != null ?
                moment(new Date(this.currentYear, this.currentMonth)).format('MMM YYYY') : ''
        },
        /**
         * Returns array of { date, dayLabel, title } in current month with event title (if it has)
         */
        eventDays () {
            return this.currentMonthMomentDates.map((momentDate) => {
                const formattedDate = momentDate.format('YYYY-MM-DD')
                return {
                    date: formattedDate,
                    dayLabel: momentDate.format('D ddd'),
                    title: _.get(_.find(this.events, { 'date': formattedDate }), 'title'),
                }
            })
        }
    },
    mounted() {
        this.renderEvents(moment().startOf('month'))
    },
    watch: {
        events: function () {
            const newDate = moment(_.get(this.events, '[0]date')).startOf('month')
            this.renderEvents(newDate)
        },
    },
    methods: {
        renderEvents (newDate) {
            this.currentYear = newDate.year()
            this.currentMonth = newDate.month()
            this.currentMonthMomentDates = this.getAllDatesOfMonthByDate(newDate)
        },
        showPrevMonth() {
            const newDate = moment(new Date(this.currentYear, this.currentMonth)).startOf('month').subtract(1, 'months')
            this.renderEvents(newDate)
        },
        showNextMonth() {
            const newDate = moment(new Date(this.currentYear, this.currentMonth)).startOf('month').add(1, 'months')
            this.renderEvents(newDate)
        },

        /**
         * Receives a moment date, returns array of moment dates for that date's month
         * e.g. pass 2-15-2020, receive 2-1-2020 until 2-29-2020
         */
        getAllDatesOfMonthByDate (momentDate) {
            const emptyArray = new Array(momentDate.daysInMonth()).fill(null)

            // use clone because moment mutates object
            const final = emptyArray.map((x, i) => momentDate.startOf('month').add(i, 'days').clone())
            return final
        }
    }
}
</script>
