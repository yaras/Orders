<div data-bind="foreach: messages">
  <div>
    <span data-bind="text: username" style="font-weight: bold"></span> on
    <span data-bind="text: date" style="font-weight: bold"></span> wrote:
    <br />
    <blockquote data-bind="text: message"></blockquote>
  </div>
</div>
