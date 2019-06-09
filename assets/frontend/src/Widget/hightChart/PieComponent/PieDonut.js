import React from 'react'
import { PieChart, Pie, Cell, Legend, ResponsiveContainer } from 'recharts';
import config from './../config/PieChartConfig'

const PieDonut = (props) => {
    return (
        <div style={{ width: '100%', height: props.height, background: 'white' }}>
            <ResponsiveContainer>
                <PieChart>
                    <Legend verticalAlign="top" height={36} />
                    <Pie
                        activeIndex={props.activeIndex}
                        activeShape={config.renderActiveShape}
                        data={props.datas}
                        dataKey="value"
                        startAngle={0}
                        endAngle={360}
                        innerRadius={100}
                        outerRadius={150}
                        onMouseEnter={props.onPieEnter}
                    >
                        {
                            props.datas.map((entry, index) => (
                                <Cell key={`cell-${index}`} fill={props.colors[index]} />
                            ))
                        }
                    </Pie>
                </PieChart>
            </ResponsiveContainer>
        </div>
    )
}

export default PieDonut