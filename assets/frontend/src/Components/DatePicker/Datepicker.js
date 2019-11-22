import React from "react";
import DateRangeSelector from "react-daterangeselector";
import "react-daterangeselector/dist/styles.min.css";
import { subDays, subWeeks, startOfWeek, startOfMonth, subMonths } from "date-fns";

function Datepicker(props) {
  return (
    <div className='col-md-12'>
      <div className='col-md-12 small-box'>
        <DateRangeSelector
          inputComponent={
            <input
              type='text'
              name='dates'
              className='form-control pull-right'
            />
          }
          options={{
            opens: "left",
            buttonClasses: ["btn btn-sm"],
            applyClass: "btn-primary",
            separator: " to ",
            applyLabel: "Apliquer",
            format: "L",
            // dateLimit: { days: 90 },
            ranges: {
              "Tous": [new Date("2019-01-01T00:00:00.000Z"), new Date()],
              "Aujourd'hui": [new Date(), new Date()],
              "Hier": [subDays(new Date(), 1), subDays(new Date(), 1)],
              "cette Semaine (lun - aujourd'huit)": [
                startOfWeek(new Date(), { locale: "fr", weekStartsOn: 1 }),
                new Date()
              ],
              "7 derniers jours": [subDays(new Date(), 7), new Date()],
              "La semaine dernière": [
                startOfWeek(subWeeks(new Date(), 1), {
                  locale: "fr",
                  weekStartsOn: 1
                }),
                startOfWeek(new Date(), { locale: "fr", weekStartsOn: 0 })
              ],
              "14 derniers jours": [subDays(new Date(), 14), new Date()],
              "Ce mois ci": [startOfMonth(new Date()), new Date()],
              "30 derniers jours": [subDays(new Date(), 30), new Date()],
              "Le mois Dernier": [
                startOfMonth(subMonths(new Date(), 1)),
                subDays(startOfMonth(new Date()), 1)
              ]
            },
            locale: {
              applyLabel: "Mettre à jours",
              cancelLabel: "Clear",
              fromLabel: "Start date",
              toLabel: "End date",
              customRangeLabel: "Personalisé"
            },
            locale: {
              format: "DD/MM/YYYY",
              separator: " -> ",
              applyLabel: "Appliquer",
              cancelLabel: "Annuler",
              fromLabel: "Du",
              toLabel: "A",
              customRangeLabel: "Personalisée",
              weekLabel: "W",
              daysOfWeek: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
              monthNames: [
                "Janvier",
                "Fevrier",
                "Mars",
                "Avril",
                "Mai",
                "Juin",
                "Juillet",
                "Aout",
                "Septembre",
                "Octobre",
                "Novembre",
                "Decembre"
              ],
              firstDay: 1
            },
            minDate: new Date("2018-10-01T00:00:00.000Z"),
            maxDate: new Date(),
            alwaysShowCalendars: true
          }}
          callback={props.getFilter}
        />
      </div>
    </div>
  );
}

export default Datepicker;
