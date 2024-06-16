function images(){
    var images = [
        '../background/Main_background1.jpg',
        '../background/Main_background2.jpg',
        '../background/Main_background3.jpg',
        '../background/Main_background4.jpg',
        '../background/Main_background5.jpg',
        '../background/Main_background6.jpg',
        '../background/Main_background7.jpg',
        '../background/Main_background8.jpg'
    ];
    
    var randomIndex = Math.floor(Math.random() * images.length);
    
    var bodyElement = document.querySelector('body');
    
    bodyElement.style.backgroundImage = 'url(' + images[randomIndex] + ')';
}