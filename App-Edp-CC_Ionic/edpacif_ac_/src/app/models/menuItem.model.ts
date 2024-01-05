export class menuItem {

    titulo: string;
    subtitulo: string;
    descripcion: string;
    urllink: string;
    // ... otras propiedades
  
    constructor( titulo: string, subtitulo: string , descripcion : string, urllink : string) {
      
      this.titulo = titulo;
      this.subtitulo = subtitulo;
      this.descripcion = descripcion;
      this.urllink = urllink;
      // inicializar otras propiedades
    }
  }