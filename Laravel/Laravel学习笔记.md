# App目录

#### Events目录（默认不存在，该目录用于存放事件类。事件类用于告知应用其他部分某个事件发生并提供灵活的、解耦的处理机制。）

php artisan event:generate

php artisan make:event Events

#### Jobs目录(默认不存在，Jobs目录用于存放队列任务，应用中的任务可以被推送到队列，也可以在当前请求生命周期内同步执行。同步执行的任务有时也被看作命令，因为它们实现了命令模式。)

php artisan make:job Jobs

##### Listeners目录(默认不存在，Listeners目录包含处理事件的类（事件监听器），事件监听器接收一个事件并提供对该事件发生后的响应逻辑，例如，UserRegistered 事件可以被 SendWelcomeEmail 监听器处理。)

php artisan event:generate

php artisan make:listener Listeners

#### Mail目录(默认不存在，Mail目录包含邮件发送类，邮件对象允许你在一个地方封装构建邮件所需的所有业务逻辑，然后使用 Mail::send 方法发送邮件。)

php artisan make:mail Mail

##### Notifications目录(默认不存在，你可以通过执行 make:notification 命令创建，Notifications目录包含应用发送的所有通知，比如事件发生通知。Laravel的通知功能将通知发送和通知驱动解耦，你可以通过邮件，也可以通过Slack、短信或者数据库发送通知。)

php artisan make:notification Notifications

#### Policies目录(默认不存在，Policies目录包含了所有的授权策略类，策略用于判断某个用户是否有权限去访问指定资源。)

php artisan make:policy Policies