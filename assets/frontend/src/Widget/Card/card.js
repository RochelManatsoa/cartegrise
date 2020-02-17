import React from 'react'
import FontAwesome from 'react-fontawesome'

const divStyle = {
    borderRadius: 10,
};
const iconStyle = {
    color: '#fffaf0a6',
};
const renderCard = (props) => {
    let template = null;
    switch (props.type) {
        case 'topCard':
            template = (
                <div className={`col-lg-${props.lgCol} col-xs-4`}>
                    <div className={`small-box bg-${props.background}`} style={divStyle} >
                        <div className={props.innerClass}>
                            <h3>{props.title}</h3>
                            <p className={props.textClass}>{props.text}</p>
                        </div>
                        <div className="icon" style={iconStyle}>
                            <FontAwesome name={props.iconName} />
                        </div>
                        {/* <a href={props.linkDetail} className="small-box-footer">
                            {props.textDetail} <i className="fa fa-arrow-circle-right"></i>
                        </a> */}
                    </div>
                </div>
            );
            break;
        default:
            template = null;
            break;
    }
    return template;
}

const Card = (props) => {
    return (
        <div>
            {renderCard(props)}
        </div>
    );
}

export default Card;