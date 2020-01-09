'use strict';
 
module.exports.handler = (event, context, callback) => {
    const response = {
        statusCode: 200,
        headers: {
            'Access-Control-Allow-Origin': '*',
        },
        body: JSON.stringify({
            result: RDS::VDI->get(event.code),
        }),
    };

    callback(null, response);
};
