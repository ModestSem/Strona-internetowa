function images(){
    var images = [
        '../Images/Main_background1.jpg',
        '../Images/Main_background2.jpg',
        '../Images/Main_background3.jpg',
        '../Images/Main_background4.jpg',
        '../Images/Main_background5.jpg',
        '../Images/Main_background6.jpg',
        '../Images/Main_background7.jpg',
        '../Images/Main_background8.jpg'
    ];
    
    var randomIndex = Math.floor(Math.random() * images.length);
    
    var bodyElement = document.querySelector('body');
    
    bodyElement.style.backgroundImage = 'url(' + images[randomIndex] + ')';
}