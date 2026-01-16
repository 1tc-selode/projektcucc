import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class Websocket {
  echo: any;

  connect(onCreate: (c:any)=>void) {
    // Check if Echo is available
    if (typeof (window as any).Echo === 'undefined') {
      console.warn('Laravel Echo is not loaded. WebSocket functionality disabled.');
      return;
    }

    try {
      this.echo = new (window as any).Echo({
        broadcaster: 'pusher',
        key: 'local',
        wsHost: '127.0.0.1',
        wsPort: 6001,
        forceTLS: false,
        disableStats: true
      });

      this.echo.channel('courses')
        .listen('CourseCreated', (e:any) => onCreate(e.course));
    } catch (error) {
      console.error('Failed to initialize WebSocket:', error);
    }
  }
}
