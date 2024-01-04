export default function useUtils(){
    const getShortTime = (dateString) =>{
        const today = new Date();

        const date = new Date(dateString);
        const dateArray =  dateString.split('T');
        const time = `${dateArray[1].split(':')[0]}:${dateArray[1].split(':')[1]}`;

        if(date.getFullYear() === today.getFullYear() && date.getMonth() === today.getMonth() && date.getDate() === today.getDate()){
            return time;
        }else{
            return dateArray[0];
        }
    }

    const getLongTime = (dateString) =>{

        const dateArray =  dateString.split('T');
        const timeArray = dateArray[1].split(':');
        const time = `${timeArray[0]}:${timeArray[1]}:${timeArray[2].split('.')[0]}`;

        return `${dateArray[0]} ${time}`;
    }


    return {
        getShortTime,
        getLongTime
    }
}




