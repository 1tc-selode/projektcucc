import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class Websocket {
  echo: any;

  connect(onCreate: (c:any)=>void) {
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
  }
}
