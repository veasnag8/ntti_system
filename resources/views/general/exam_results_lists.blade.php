
<div class="control-table table-responsive custom-data-table-wrapper2">
    <table class="table table-striped">
      <thead>
        <tr>
          <th width="50"></th>
          <th class="text-center">ថា្នក់/ក្រុម</th>
          <th class="text-center">វេន</th>
          <th class="text-center">ជំនាញ</th>
          <th class="text-center">ដេប៉ាតឺម៉ង់</th>
          <th class="text-center">ឆមាស</th>
          <th class="text-center">គ្រូបន្ទុកថ្នាក់</th>
          <th class="text-center" >ឆ្នាំសិក្សា</th>
        </tr>
      </thead>
      <tbody>
        @include('general.exam_results_records')
      </tbody>
    </table>
    {{$records->links("pagination::bootstrap-4")}}
  </div><br><br>